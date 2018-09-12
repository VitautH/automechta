<?php

namespace backend\controllers;

use yii\web\Controller;
use backend\models\LiveChatResponse;
use backend\models\LiveChat;
use backend\models\LiveChatDialog;
use yii\db\Query;
use backend\models\LiveChatModel;
use Yii;
use yii\web\Response;
use yii\helpers\Json;

class ChatController extends Controller
{
    private $dialogId;
    private $extension;
    private $fileType;
    private $fileName;
    private $userId;
    private $clientId;

    /**
     * @return bool
     */
    public function beforeAction($action)
    {
        if ($action->id === 'UploadFile') {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $model = new  LiveChatModel();
        $model->getNewDialogs()->getOldDialogs()->getDialog();


        return $this->render('index', [
            'newChats' => $model->newDialog,
            'oldChats' => $model->oldDialog,
            'firstChat' => $model->dialogInfo,
            'dialog' => $model->dialog
        ]);
    }

    public function actionUploadFile()
    {
        if (isset($_POST['file'])) {
            $request = Yii::$app->request;
            $this->dialogId = $request->post('dialog_id');
            $this->userId = $request->post('user_id');
            $this->clientId = $request->post('client_id');
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
                    $model->from = 'manager';
                    $model->to = 'user';
                    $model->attach = '/uploads/chat/' . $this->dialogId . DIRECTORY_SEPARATOR . $fileName;
                    $model->viewed = LiveChatDialog::VIEWED;
                    if ($model->save()) {
                        
                        // All message set status Viewed
                        $this->_updateStatusViewed();
                        Yii::$app->redis->executeCommand('PUBLISH', [
                            'channel' => 'chatToUserLoadImage',
                            'message' => Json::encode(['client_id' => $this->clientId, 'user_id' => $this->userId, 'path' => $model->attach, 'dialog_id' => $this->dialogId])
                        ]);
                        $result['status'] = 'success';
                        $result['path'] = $model->attach;
                        $result['id'] = $model->id;
                    } else {
                        $result['status'] = 'failed';
                    }
                } else {
                    $result['status'] = 'failed';
                }
            }
            return json_encode($result);
        }
    }

    public function actionLoadDialog($id)
    {
        if (Yii::$app->request->isAjax) {
            $model = new  LiveChatModel();
            $model->getDialog($id);

            return $this->renderAjax('_chat', ['firstChat' => $model->dialogInfo, 'dialog' => $model->dialog]);
        }
    }

    private function _updateStatusViewed()
    {
        LiveChatDialog::updateAll(['viewed' => LiveChatDialog::VIEWED], 'live_chat_id = ' . $this->dialogId . '');
    }
}