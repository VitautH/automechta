<?php

namespace common\models;

use common\models\AutoMakes;
use common\models\AutoModels;
use common\models\AutoModifications;

class ImageModifications extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'modification_image';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['modifications_id'], 'integer'],
            [['modifications_id'], 'required'],
            [['url'], 'string'],
        ];
    }
}