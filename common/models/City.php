<?php
/**
 * Created by PhpStorm.
 * User: Vitaut
 * Date: 29.12.2017
 * Time: 12:02
 */

namespace common\models;
use Yii;
use common\models\Region;

class City extends \yii\db\ActiveRecord
{

    public static function getCityName ($cityId){
        $city_name = City::find()->where(['id'=>$cityId])->one();

        return $city_name->city_name;
    }
}