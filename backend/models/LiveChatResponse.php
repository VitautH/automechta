<?php
/**
 * Created by PhpStorm.
 * User: Vitaut
 * Date: 24.05.2018
 * Time: 16:14
 */

namespace backend\models;


class LiveChatResponse extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'live_chat_response_msg';
    }
}