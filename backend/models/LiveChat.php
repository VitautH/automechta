<?php

namespace backend\models;


class LiveChat extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'live_chat';
    }
}