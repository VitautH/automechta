<?php
/**
 * Created by PhpStorm.
 * User: Vitaut
 * Date: 29.12.2017
 * Time: 12:02
 */

namespace common\models;

use Yii;

class Region extends \yii\db\ActiveRecord
{
    public static function getRegions()
    {
        $regions = [
            '2' => 'Минская область',
            '7' => 'Брестская область',
            '5' => 'Витебская область',
            '3' => 'Гомельская область',
            '6' => 'Гродненская область',
            '4' => 'Могилёвская область'];

        return $regions;
    }

    public static function getRegionName ($regionId){
        $region_name = Region::find()->where(['id'=>$regionId])->one();

        return $region_name->region_name;
    }
}