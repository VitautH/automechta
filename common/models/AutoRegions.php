<?php
/**
 * Created by PhpStorm.
 * User: Vitaut
 * Date: 02.04.2018
 * Time: 15:56
 */

namespace common\models;


class AutoRegions extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'auto_regions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['region_name'], 'string'],
        ];
    }
}