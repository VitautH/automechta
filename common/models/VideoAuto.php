<?php

namespace common\models;

use Yii;
use yii\db\Query;
use yii\helpers\Url;
use yii\base\Event;

class VideoAuto extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'video_auto';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type_id','make_id'], 'integer'],
            [['model', 'video_url'], 'string'],
        ];
    }
}