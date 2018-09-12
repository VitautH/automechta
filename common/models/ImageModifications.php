<?php

namespace common\models;

use common\models\AutoMakes;
use common\models\AutoModels;
use common\models\AutoModifications;
use Yii;
use yii\web\UploadedFile;
use Imagine\Image\ManipulatorInterface;
use yii\imagine\Image;

class ImageModifications extends \yii\db\ActiveRecord
{


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'auto_modification_image';
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