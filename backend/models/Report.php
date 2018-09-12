<?php

namespace backend\models;

use backend\models\Reports;
use common\helpers\Date;

class Report extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'report';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['report_id','report_field','report'], 'required'],
            [['report'], 'string'],
            [['report_id','report_field'], 'integer'],
        ];
    }
}