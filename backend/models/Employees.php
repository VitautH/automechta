<?php

namespace backend\models;

use yii\db\Query;
use yii\base\Model;
use common\models\AuthAssignment;

class Employees extends Model
{

    /* Get All Employees
     * @return array
     */
    public static function getEmployees(){
        $query = new Query;
        $query	->select('*')
            ->from('user')
            ->leftJoin(AuthAssignment::tableName(), 'user_id =id')
            ->andWhere(['or',
                ['item_name' => 'Administrator'],
                ['item_name' => 'Manager'],
                ['item_name' => 'CallCentr'],
                ['item_name' => 'Specialist'],
            ])
            ->all();

        $command = $query->createCommand();
        $employees = $command->queryAll();

        return $employees;
    }
}