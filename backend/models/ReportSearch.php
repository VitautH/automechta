<?php

namespace backend\models;

use common\models\User;
use yii\db\Query;
use common\helpers\Date;
use yii\data\ActiveDataProvider;
use backend\models\Tasks;

class ReportSearch extends Reports
{
    const SCENARIO_SEARCH = 'search';


    public function init()
    {
        $this->setScenario(self::SCENARIO_SEARCH);
        parent::init();
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_SEARCH] = [
            'user_id',
            'report_date',
        ];

        return $scenarios;
    }

    /*
     * Search report from employees
     * @return array()
     */
    public function search()
    {
        $query = new Query;

        if ($this->user_id == 0) {

            $query = new Query;
            $query->select('report_date,user_id')
                ->from(Reports::tableName())
                ->where(['report_date' => Date::dateToUnix($this->report_date)])
                ->all();
            $command = $query->createCommand();
            $employeesReport = $command->queryAll();

            /*
               * Tasks
               */
            $query = new Query;
            $query->select('employee_to AS user_id, execute_date, updated_at')
                ->from(Tasks::tableName())
                ->where(['like', "(date_format( FROM_UNIXTIME(`updated_at` ), '%m/%d/%Y' ))", $this->report_date])
                ->all();
            $command = $query->createCommand();
            $employeesTask = $command->queryAll();
            unset($query);

            /**
             * Union Users Reports and Users Task
             */
            $users = array_merge($employeesReport, $employeesTask);

            function unique_multidim_array($array, $key)
            {
                $temp_array = array();
                $i = 0;
                $key_array = array();

                foreach ($array as $val) {
                    if (!in_array($val[$key], $key_array)) {
                        $key_array[$i] = $val[$key];
                        $temp_array[$i] = $val;
                    }
                    $i++;
                }
                return $temp_array;
            }

            $employees = unique_multidim_array($users, 'user_id');



            if (count($employees) == 0) {
                return false;
            }
            unset($query);

            $report = array();
            foreach ($employees as $i => $employee) {

                /*
                 * Reports
                 */
                $query = new Query;
                $query->select('*')
                    ->from(Reports::tableName())
                    ->leftJoin(Report::tableName(), '' . Reports::tableName() . '.id = ' . Report::tableName() . '.report_id')
                    ->where(['user_id' => $employee['user_id']])
                    ->andWhere(['report_date' => Date::dateToUnix($this->report_date)])
                    ->all();
                $command = $query->createCommand();
                $results = $command->queryAll();

                /*
                 * Tasks
                 */
                $query = new Query;
                $query->select('*')
                    ->from(Tasks::tableName())
                    ->where(['employee_to' => $employee['user_id']])
                    ->andWhere(['like', "(date_format( FROM_UNIXTIME(`updated_at` ), '%m/%d/%Y' ))", $this->report_date])
                    ->all();
                $command = $query->createCommand();
                $resultsTask = $command->queryAll();

                $employeeReport = User::findOne($employee['user_id']);
                $report [$i]["user"] = ['employees' => $employeeReport->last_name . ' ' . $employeeReport->first_name, 'report_date' => date("d.m.Y", strtotime($this->report_date))];

                foreach ($results as $n => $result) {
                    $report  [$i]["user"]['tasks'][$n] = [
                        'report_field' => ReportField::find()->where(['id' => $result['report_field']])->one()->name_field,
                        'report' => $result['report'],
                    ];
                }


                /*
                 * Task
                 */
                foreach ($resultsTask as $j => $task) {

                    switch ($task['status']) {
                        case Tasks::OPEN_STATUS:
                            $status = 'Создана задача';
                            break;
                        case Tasks::DURING_STATUS:
                            $status = 'Выполняется';
                            break;
                        case Tasks::EXECUTED_STATUS:
                            $status = 'Выполнена';
                            break;
                        case Tasks::CLOSED_STATUS:
                            $status = 'Закрыта (одобрена)';
                            break;
                        case Tasks::DECLINE_STATUS:
                            $status = 'Отклонена (на доработку)';
                            break;
                    }

                    $report  [$i]["user"]['tasks']['additional_task'][$j] = [
                        'id' => $task['id'],
                        'report_field' => $task['title'],
                        'report' => $status,
                    ];
                }
            }
        } else {
            $query->select('*')
                ->from(Reports::tableName())
                ->leftJoin(Report::tableName(), '' . Reports::tableName() . '.id = ' . Report::tableName() . '.report_id')
                ->where(['report_date' => Date::dateToUnix($this->report_date)])
                ->andWhere(['user_id' => $this->user_id])
                ->all();
            $command = $query->createCommand();

            $employeesReport = $command->queryAll();

            /*
              * Tasks
              */
            $query = new Query;
            $query->select('employee_to AS user_id, execute_date, updated_at')
                ->from(Tasks::tableName())
                ->where(['employee_to' => $this->user_id])
                ->andWhere(['like', "(date_format( FROM_UNIXTIME(`updated_at` ), '%m/%d/%Y' ))", $this->report_date])
                ->all();
            $command = $query->createCommand();
            $employeesTask = $command->queryAll();
            unset($query);

            /**
             * Union Users Reports and Users Task
             */
            $users = array_merge($employeesReport, $employeesTask);

            function unique_multidim_array($array, $key)
            {
                $temp_array = array();
                $i = 0;
                $key_array = array();

                foreach ($array as $val) {
                    if (!in_array($val[$key], $key_array)) {
                        $key_array[$i] = $val[$key];
                        $temp_array[$i] = $val;
                    }
                    $i++;
                }
                return $temp_array;
            }

            $employee = unique_multidim_array($users, 'user_id');

            if (count($employee) == 0) {
                return false;
            } else {
                $report = array();
                $employees = User::findOne($this->user_id);
                $report [0]["user"] = ['employees' => $employees->last_name . ' ' . $employees->first_name, 'report_date' => date("d.m.Y", strtotime($this->report_date))];
                foreach ($employee as $n => $result) {
                    $report  [0]["user"]['tasks'][$n] = [
                        'report_field' => ReportField::find()->where(['id' => $result['report_field']])->one()->name_field,
                        'report' => $result['report'],
                    ];
                }

                /*
               * Task
               */
                /*
              * Tasks
              */
                $query = new Query;
                $query->select('*')
                    ->from(Tasks::tableName())
                    ->where(['employee_to' => $this->user_id])
                    ->andWhere(['like', "(date_format( FROM_UNIXTIME(`updated_at` ), '%m/%d/%Y' ))", $this->report_date])
                    ->all();
                $command = $query->createCommand();
                $resultsTask = $command->queryAll();
                foreach ($resultsTask as $j => $task) {

                    switch ($task['status']) {
                        case Tasks::OPEN_STATUS:
                            $status = 'Создана задача';
                            break;
                        case Tasks::DURING_STATUS:
                            $status = 'Выполняется';
                            break;
                        case Tasks::EXECUTED_STATUS:
                            $status = 'Выполнена';
                            break;
                        case Tasks::CLOSED_STATUS:
                            $status = 'Закрыта (одобрена)';
                            break;
                        case Tasks::DECLINE_STATUS:
                            $status = 'Отклонена (на доработку)';
                            break;
                    }

                    $report  [0]["user"]['tasks']['additional_task'][$j] = [
                        'id' => $task['id'],
                        'report_field' => $task['title'],
                        'report' => $status,
                    ];
                }
            }

        }

        return $report;
    }

    public function searchReportUser($params = null)
    {
        $query = Reports::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);


        $query->where(['user_id' => $this->user_id]);
        if (!empty($this->report_date) && $this->report_date != null) {
            $query->andFilterWhere(['report_date' => Date::dateToUnix($this->report_date)]);
        }

        return $dataProvider;
    }
}