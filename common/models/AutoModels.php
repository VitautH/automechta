<?php

namespace common\models;

use common\models\AutoSpecifications;
use common\models\AutoMakes;

class AutoModels extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'auto_models';
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['make_id'], 'integer'],
            [['make_id', 'model'], 'required'],
            [['model', 'years', 'description'], 'string'],
        ];
    }
}