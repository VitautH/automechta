<?php

namespace backend\models;

use yii\behaviors\TimestampBehavior;
use backend\models\Report;
use common\helpers\Date;

class Reports extends \yii\db\ActiveRecord
{
    const NO_VIEWED = 0;
    const VIEWED = 1;
    public $report_field;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'reports';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'report_date'], 'required'],
            [['user_id', 'viewed', 'edited', 'report_date'], 'integer']
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
            ],
        ];
    }

    public static function triggerFlagView()
    {
        $models = Reports::findAll(['viewed' => 0]);

        foreach ($models as $model) {
            $report = Reports::findOne($model->id);
            $report->viewed = 1;
            $report->save();
        }
    }
}