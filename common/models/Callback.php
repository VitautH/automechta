<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Query;
use yii\helpers\Url;
use yii\helpers\Json;

class Callback extends \yii\db\ActiveRecord
{
    const VIEWED = 1;
    const NO_VIEWED = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'callback';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['phone',], 'required'],
            [['name', 'phone'], 'safe']
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

    public function afterSave($insert, $changedAttributes)
    {
        Yii::$app->redis->executeCommand('PUBLISH', [
            'channel' => 'notification',
            'message' => Json::encode([ 'message' => 'Обратный звонок'])
        ]);
        parent::afterSave($insert, $changedAttributes);
    }
}