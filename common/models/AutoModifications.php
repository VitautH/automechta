<?php

namespace common\models;

use common\models\AutoSpecifications;
use common\models\AutoMakes;
use common\models\AutoModels;

class AutoModifications extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'auto_modifications';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['model_id','region_id','make_id', 'type_body'], 'integer'],
            [['model_id','region_id','make_id'], 'required'],
            [['modification_name', 'slug', 'years'], 'string'],
        ];
    }
}