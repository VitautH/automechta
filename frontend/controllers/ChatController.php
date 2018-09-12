<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\web\UploadedFile;
use backend\models\LiveChat;
use backend\models\LiveChatDialog;
use yii\helpers\Json;

class ChatController extends Controller
{
    private $dialogId;
    private $extension;
    private $fileType;
    private $fileName;


    /**
     * @return bool
     */
    public function beforeAction($action)
    {
        if (isset($_COOKIE['chat_guest_id'])) {
            $user_id = $_COOKIE['chat_guest_id'];
            $this->dialogId = LiveChat::find()->where(['user_id' => $user_id])->one()->id;
        } else {
            Yii::$app->user->denyAccess();
        }

        if ($action->id === 'UploadFile') {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }

    public function actionUploadFile()
    {
        if (isset($_POST['file'])) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $result = [];
            $dir = '/home/admin/web/automechta.by/public_html/frontend/web/uploads/chat/' . $this->dialogId;

            if (!file_exists($dir . DIRECTORY_SEPARATOR) && !is_dir($dir . DIRECTORY_SEPARATOR)) {
                mkdir($dir . DIRECTORY_SEPARATOR, 0755, true);
            }

            $files = $_FILES;

            foreach ($files as $file) {
                $this->fileName = $file['name'];
                $this->fileType = strtolower($file['type']);
                $this->extension = pathinfo($this->fileName, PATHINFO_EXTENSION);
                $whitelist = ["jpg", "jpeg", "gif", "png"];
                if (!(in_array($this->extension, $whitelist))) {
                    die('not allowed extension,please upload images only');
                }

                $pos = strpos($this->fileType, 'image');
                if ($pos === false) {
                    die('error 1');
                }
                $imageinfo = getimagesize($file['tmp_name']);
                if ($imageinfo['mime'] != 'image/gif' && $imageinfo['mime'] != 'image/jpeg' && $imageinfo['mime'] != 'image/jpg' && $imageinfo['mime'] != 'image/png') {
                    die('error 2');
                }

                if (substr_count($this->fileType, '/') > 1) {
                    die('error 3');
                }
                $fileName = md5($this->fileName) . '.' . $this->extension;
                $path = $dir . DIRECTORY_SEPARATOR . $fileName;

                if (move_uploaded_file($file['tmp_name'], $path)) {

                    $model = new LiveChatDialog();
                    $model->live_chat_id = $this->dialogId;
                    $model->from = 'user';
                    $model->to = 'manager';
                    $model->attach = '/uploads/chat/' . $this->dialogId . DIRECTORY_SEPARATOR . $fileName;
                    if ($model->save()) {
                        Yii::$app->redis->executeCommand('PUBLISH', [
                            'channel' => 'chatToManagerLoadImage',
                            'message' => Json::encode(['path' => $model->attach, 'dialog_id' => $this->dialogId])
                        ]);
                        $result['status'] = 'success';
                        $result['path'] = $model->attach;
                        $result['id'] = $model->id;
                    } else {
                        $result['status'] = 'failed';
                    }
                }
            }
            return json_encode($result);
        }
    }
}