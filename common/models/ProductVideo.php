<?php

namespace common\models;

use Yii;
use yii\db\Query;
use yii\helpers\Url;
use yii\base\Event;

class ProductVideo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_video';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id','product_type','product_make','year'], 'integer'],
            [['model', 'video_url'], 'string'],
        ];
    }
}