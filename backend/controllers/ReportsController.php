<?php

namespace backend\controllers;

use Yii;
use yii\web\Response;
use yii\filters\VerbFilter;
use backend\models\ReportField;
use common\models\AuthItem;
use yii\data\ActiveDataProvider;
use backend\models\Reports;
use backend\models\Report;
use common\helpers\Date;
use yii\db\Query;
use common\models\User;
use backend\models\ReportSearch;
use backend\models\Employees;
use yii\web\NotFoundHttpException;
use backend\models\Tasks;

class ReportsController extends \yii\web\Controller
{
    public $reportId;

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'create' => ['post'],
                ],
            ],
        ];
    }


    public function actionCreate()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            $requests = Yii::$app->request->post();
            $result = false;
            $reportDate = Date::dateToUnix($requests["Reports"]["report_date"]);
            $reportUserId = $requests["Reports"]["user_id"];
            $currentReport = Reports::find()->where(['user_id' => $reportUserId])->andWhere(['report_date' => $reportDate])->one();

            if ($currentReport == null) {

                $reports = new Reports();
                $reports->user_id = $reportUserId;
                $reports->report_date = $reportDate;

                if (!$reports->save()) {
                    return ['status' => 'failed'];
                }

                $this->reportId = $reports->id;
                unset($reports);


                foreach ($requests["Reports"]["report_field"] as $key => $value) {
                    if (!empty ($value)) {

                        $report = new Report();
                        $report->report_field = $key;
                        $report->report = $value;
                        $report->report_id = $this->reportId;
                        $result = $report->save();
                    }
                }

                if ($result === true) {
                    return ['status' => 'success'];
                } else {
                    return ['status' => 'failed', 'message' => null];
                }
            } else {
                return ['status' => 'failed', 'message' => 'У вас уже есть отчёт за эту дату. Вы можете отредактировать отчёт'];
            }

        } else {
            Yii::$app->user->denyAccess();
        }
    }

    public function actionIndex()
    {
        if (!Yii::$app->user->can('viewReports')) {
            Yii::$app->user->denyAccess();
        }

        /*
                  * Tasks
                  */
        $query = new Query;
        $query->select('employee_to AS user_id, execute_date, updated_at')
            ->from(Tasks::tableName())
            ->where(['like', "(date_format( FROM_UNIXTIME(`updated_at` ), '%Y-%m-%d' ))", date('Y-m-d')])
            ->all();
        $command = $query->createCommand();
        $employeesTask = $command->queryAll();
        unset($query);


        /*
         * Reports
         */
        Reports::triggerFlagView();

        $query = new Query;
        $query->select('report_date,user_id')
            ->from(Reports::tableName())
            ->where(['report_date' => Date::dateToUnix(date('Y-m-d'))])
            ->all();
        $command = $query->createCommand();
        $users = $command->queryAll();
        unset($query);

        /*
         * Union Users Reports and Users Task
         */
        $users = array_merge($employeesTask, $users);

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

        $users = unique_multidim_array($users, 'user_id');

        $currentReports = [];

        foreach ($users as $i => $user) {

            /*
             * Reports
             */
            $query = new Query;
            $query->select('*')
                ->from(Reports::tableName())
                ->leftJoin(Report::tableName(), '' . Reports::tableName() . '.id = ' . Report::tableName() . '.report_id')
                ->where(['report_date' => Date::dateToUnix(date('Y-m-d'))])
                ->andWhere(['user_id' => $user['user_id']])
                ->all();
            $command = $query->createCommand();
            $results = $command->queryAll();

            /*
             * Task
             */
            $query = new Query;
            $query->select('*')
                ->from(Tasks::tableName())
                ->where(['employee_to' => $user['user_id']])
                ->andWhere(['like', "(date_format( FROM_UNIXTIME(`updated_at` ), '%Y-%m-%d' ))", date('Y-m-d')])
                ->all();
            $command = $query->createCommand();
            $resultsTask = $command->queryAll();


            $currentReports [$i]["user"] = [
                'user_id' => $user['user_id'],
                'report_updated_at' => function ($results) {
                    if ($results['edited'] == 1) {
                        return date('d-m-Y', $results['updated_at']);
                    }
                }
            ];

            foreach ($results as $n => $result) {
                $currentReports [$i]["user"] ['tasks'][$n] = [
                    'report_field' => ReportField::find()->where(['id' => $result['report_field']])->one()->name_field,
                    'report' => $result['report'],
                    'report_date' => $result['report_date'],

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

                $currentReports  [$i]["user"]['tasks']['additional_task'][$j] = [
                    'id' => $task['id'],
                    'report_field' => $task['title'],
                    'report' => $status,
                ];
            }
        }

        $employees = Employees::getEmployees();
        $employeesArray = array();

        $employeesArray[0]['id'] = 0;
        $employeesArray[0]['name'] = 'Все сотрудники';
        $i = 1;
        foreach ($employees as $employee) {
            $employeesArray[$i]['id'] = $employee['id'];
            $employeesArray[$i]['name'] = $employee['last_name'] . ' ' . $employee['first_name'];
            $i++;
        }

        $modelSearchReport = new ReportSearch();

        return $this->render('index', [
            'currentReports' => $currentReports,
            'modelSearchReport' => $modelSearchReport,
            'employees' => $employeesArray
        ]);
    }

    public function actionSearch()
    {
        if (!Yii::$app->user->can('viewReports')) {
            Yii::$app->user->denyAccess();
        }

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            $search = new ReportSearch();
            $search->load(Yii::$app->request->post());
            $result = $search->search();

            return $result;
        } else {
            Yii::$app->user->denyAccess();
        }
    }

    /* User Reports
     * params User Id
     * @return dataProvider, searchModel
     */
    public function actionReportUser()
    {
        $searchModel = new ReportSearch();
        $params = Yii::$app->request->get();
        $searchModel->setAttribute('user_id', Yii::$app->user->id);

        /** @var ActiveDataProvider $dataProvider */
        $dataProvider = $searchModel->searchReportUser($params);
        $dataProvider->query->orderBy('report_date DESC');

        return $this->render('report-user', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            '_params_' => $params
        ]);
    }

    public function actionReportUpdate($id = null)
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $requests = Yii::$app->request->post();
            $result = false;
            $reportId = $requests["Reports"]["id"];
            $reportsModel = Reports::find()->where(['id' => $reportId])->andWhere(['user_id' => Yii::$app->user->id])->one();

            if ($reportsModel == null) {
                return ['status' => 'failed'];
            } else {
                foreach ($requests["Reports"]["report_field"] as $key => $value) {
                    $reportModel = Report::find()->where(['report_id' => $reportId])->andWhere(['report_field' => $key])->one();
                    $reportModel->report = $value;
                    $result = $reportModel->save();
                }
                if ($result) {
                    $reportsModel->edited = true;
                    $result = $reportsModel->save();
                }
            }

            if ($result) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'Saved'));
                return $this->redirect('/reports/report-user');
            } else {
                return ['status' => 'failed'];
            }

        } else {

            if ($id == null) {
                throw new NotFoundHttpException('The requested page does not exist.');
            }

            $query = new Query;
            $query->select('*')
                ->from(Reports::tableName())
                ->leftJoin(Report::tableName(), '' . Reports::tableName() . '.id = ' . Report::tableName() . '.report_id')
                ->leftJoin(ReportField::tableName(), '' . Report::tableName() . '.report_field = ' . ReportField::tableName() . '.id')
                ->where([Reports::tableName() . '.id' => $id])
                ->andWhere([Reports::tableName() . '.user_id' => Yii::$app->user->id])
                ->all();
            $command = $query->createCommand();
            $reports = $command->queryAll();


            if ($reports == null) {
                throw new NotFoundHttpException('The requested page does not exist.');
            }


            $reportArray = [];
            $reportArray["report_date"] = $reports[0]["report_date"];
            $reportArray["report_id"] = $reports[0]["report_id"];

            foreach ($reports as $i => $report) {
                $reportArray["reports"][$i]["report_field_id"] = $report["report_field"];
                $reportArray["reports"][$i]["report_type_field"] = $report["report_type_field"];
                $reportArray["reports"][$i]["report_field_name"] = $report["name_field"];
                $reportArray["reports"][$i]["report"] = $report["report"];
            }

            return $this->render('report-update', [
                'model' => $reportArray,
            ]);
        }
    }
}