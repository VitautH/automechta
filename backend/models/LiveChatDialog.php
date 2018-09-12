<?php

namespace backend\models;

use yii\db\Query;
use Yii;
use yii\web\UploadedFile;
use Imagine\Image\ManipulatorInterface;
use yii\imagine\Image;


class LiveChatDialog extends \yii\db\ActiveRecord
{
    const  NO_VIEWED = 0;
    const  VIEWED = 1;

    public $dialogId;
    /**
     * @var UploadedFile
     */
    public $imageFiles;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'live_chat_dialog';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['live_chat_id', 'viewed'], 'integer'],
            [['live_chat_id', 'from', 'to'], 'required'],
            [['message', 'attach', 'from', 'to'], 'string'],
           // [['imageFiles'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, doc,docx,txt,pdf', 'maxFiles' => 10],
        ];
    }

    public function upload()
    {
        $result = false;


        $dir = '/home/admin/web/automechta.by/public_html/frontend/web/uploads/chat/' . $this->dialogId;

        if (!file_exists($dir . DIRECTORY_SEPARATOR) && !is_dir($dir . DIRECTORY_SEPARATOR)) {
            mkdir($dir . DIRECTORY_SEPARATOR, 0755, true);
        }

        if ($this->validate()) {
            ini_set('memory_limit', -1);
                $fileName = md5($this->imageFiles->baseName) . '.' . $this->imageFiles->extension;
                $path = $dir . DIRECTORY_SEPARATOR . $fileName;
                if ($this->imageFiles->saveAs($path)) {
                    $this->attach = '/uploads/chat/' . $this->dialogId . DIRECTORY_SEPARATOR . $fileName;
                    if ($this->save()) {
                        $result = array();
                        $result['status'] = 'success';
                        $result['path'] = $path;
                        $result['id'] = $this->id;
                    }
                }
        } else {
            return $this->getErrors();
        }
        return $result;
    }
}