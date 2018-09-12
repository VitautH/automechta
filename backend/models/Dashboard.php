<?php

namespace backend\models;

use common\models\User;
use yii\base\Model;
use common\models\Product;
use common\models\AuthAssignment;
use common\models\CreditApplication;
use common\models\CreditApplicationSearch;
use DateTime;
use DatePeriod;
use DateInterval;
use DateTimeInterface;
use yii\db\Query;

class Dashboard extends Model
{
    /*
     * Days of month
     * @return array()
     */
    public static function getDaysOfMonth()
    {
        $from = new DateTime(date("Y-m-01"));
        $to = new DateTime(date("Y-m-t"));

        $period = new DatePeriod($from, new DateInterval('P1D'), $to);

        $arrayOfDates = array_map(
            function ($item) {
                return $item->format('Y-m-d');
            },
            iterator_to_array($period)
        );

        return $arrayOfDates;
    }

    /*
   * Count product of month
   * @return integer
   */
    public static function getCountProductMonth()
    {
        $arrayOfDates = self::getDaysOfMonth();
        $countProductMonth = Product::find()->andFilterWhere([
            'between',
            'FROM_UNIXTIME(created_at, "%Y-%m-%d")',
            date('Y-m-01'),
            date('Y-m-t')
        ])->andFilterWhere(['!=', 'status', Product::STATUS_BEFORE_CREATE_ADS])->andFilterWhere(['!=', 'status', Product::STATUS_TO_BE_VERIFIED])->count();

        return $countProductMonth;
    }

    /*
 * Count user of month
 * @return integer
 */
    public static function getCountUserMonth()
    {

        $query = new Query;
        $query->select('*')
            ->from('user')
            ->leftJoin('auth_assignment', 'user_id =id')
            ->where([
                'between',
                'FROM_UNIXTIME(user.created_at, "%Y-%m-%d")',
                date('Y-m-01'),
                date('Y-m-t')
            ])
            ->andWhere(['!=', 'item_name', 'RegisteredUnconfirmed'])
            ->count();

        $command = $query->createCommand();
        $countUserMonth = $command->queryAll();

        return count($countUserMonth);
    }

    /*
     * Chart credit-application of month
     * @return array: days, count credit application on days of month
     */
    public static function chartCreditApplicationMonth()
    {
        $arrayData = array();
        $arrayOfDates = self::getDaysOfMonth();
        $days = "[";
        $countCreditApplication = "[";
        foreach ($arrayOfDates as $key => $value) {

            $days .= "'";
            $days .= $value;
            $days .= "',";


            $credit = new CreditApplicationSearch();
            $params ["CreditApplicationSearch"]["created_at"]=''.$value.' / '.$value.'';
            $credit->load($params);
            $countCreditApplication .=$credit->search()->totalCount;
            $countCreditApplication .= ",";
        }
        $countCreditApplication .= "]";
        $days .= "]";

        $arrayData ['days'] = $days;
        $arrayData ['countCreditApplication'] = $countCreditApplication;

        return $arrayData;
    }

}