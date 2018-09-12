<?php

namespace backend\controllers;

use Yii;
use yii\web\Response;
use yii\filters\VerbFilter;
use common\models\User;
use backend\models\PrivateMessage;
use backend\models\OwnerMessage;
use backend\models\RecipientMessage;

class MessageController extends \yii\web\Controller
{
    private $messageId;

    public function actionSend()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $request = Yii::$app->request->post();
            $message = new PrivateMessage();
            $message->message = $request['message'];
            if ($message->save()) {
                $this->messageId = $message->id;
            } else {
                return ['status' => 'failed'];
            }


            $ownerMessage = new OwnerMessage();
            $ownerMessage->owner_user = Yii::$app->user->id;
            $ownerMessage->recipient_user = $request['to'];
            $ownerMessage->message_id = $this->messageId;
            if (!$ownerMessage->save()) {
                PrivateMessage::deleteAll(['id' => $this->messageId]);

                return ['status' => 'failed'];
            }

            $recipientMessage = new RecipientMessage();
            $recipientMessage->message_id = $this->messageId;
            $recipientMessage->owner_user = Yii::$app->user->id;
            $recipientMessage->recipient_user = $request['to'];
            if ($recipientMessage->save()) {
                return ['status' => 'success'];
            } else {
                RecipientMessage::deleteAll(['id' => $ownerMessage->id]);
                return ['status' => 'failed'];
            }


        } else {
            Yii::$app->user->denyAccess();
        }

    }

}