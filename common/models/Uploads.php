<?php

namespace common\models;

use Yii;
use yii\base\Exception;
use yii\web\UploadedFile;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\helpers\Url;
use Imagine\Image\ManipulatorInterface;
use yii\imagine\Image;
use common\models\AppData;

/**
 * This is the model class for table "uploads".
 *
 * @property integer $id
 * @property string $linked_table
 * @property integer $linked_id
 * @property integer $type
 * @property integer $status
 * @property string $name
 * @property string $hash
 * @property string $extension
 * @property integer $size
 * @property integer $mime_type
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 */
class Uploads extends \yii\db\ActiveRecord
{

    const TYPE_REGULAR = 0;
    const TYPE_TITLE = 1;

    /**
     * @var UploadedFile
     */
    public $file;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'uploads';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['linked_id', 'type', 'status', 'size', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['linked_table', 'hash', 'extension', 'size', 'name'], 'required'],
            [['linked_table', 'name', 'hash', 'extension', 'mime_type'], 'string', 'max' => 256],
            [['file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, gif, xls, doc, jpeg', 'maxSize' => 10485760],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'linked_table' => Yii::t('app', 'Linked Table'),
            'linked_id' => Yii::t('app', 'Linked ID'),
            'type' => Yii::t('app', 'Type'),
            'status' => Yii::t('app', 'Status'),
            'name' => Yii::t('app', 'Name'),
            'hash' => Yii::t('app', 'Hash'),
            'extension' => Yii::t('app', 'Extension'),
            'size' => Yii::t('app', 'Size'),
            'mime_type' => Yii::t('app', 'Mime Type'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
            ],
            [
                'class' => BlameableBehavior::className(),
            ],
        ];
    }

    public function upload()
    {
        $file = $this->file;
        $result = false;
        $hash = $this->getHash($file);
        $hashDir = Yii::$app->uploads->getFolderPathByHash($hash);

        if (!file_exists($hashDir) && !is_dir($hashDir)) {
            mkdir($hashDir, 0755, true);
        }

        $this->setAttributes([
            'hash' => $hash,
            'extension' => $file->extension,
            'size' => $file->size,
            'name' => $file->name,
            'mime_type' => $file->type,
        ]);

        if ($this->validate()) {
            ini_set('memory_limit', -1);
            $path = $hashDir . DIRECTORY_SEPARATOR . $hash . '.' . $file->extension;
            $result = ($this->save() && $file->saveAs($path));

            if ($result && Yii::$app->uploads->isImage($path)) {
                Yii::$app->uploads->limitSize($hash);
            }
        }

        try {
            $this->setWatermark($path);
        } catch (Throwable $t) {
            return $result;
        } catch (Exception $e) {
              return $result;
        }


        return $result;
    }

    /* Watermark
     *  @return void
     */
   private function setWatermark($path)
    {
        /*
         * Watermark Logo (image)
         */
       $appData = AppData::getData();
        $photosize = getimagesize($path);
        $watermarkfile = Yii::$app->uploads->getThumbnail($appData['logo']->hash, 220, 180, 'inset');
        $watermarksize = getimagesize($watermarkfile);
       $posX= ($photosize[0] / 2) - ($watermarksize[0] / 2);
       $posY= ($photosize[1]/ 2) - ($watermarksize[1] / 2);

        Image::watermark($path, \Yii::getAlias('@webroot') . $watermarkfile, [$posX, $posY])->save($path);
    }

    /**
     * @return string
     */
    public function getAbsoluteUrl()
    {
        $path = Yii::$app->uploads->getFolderUrlByHash($this->hash);
        return $path . '/' . $this->hash . '.' . $this->extension;
    }

    public function beforeDelete()
    {
        $path = Yii::$app->uploads->getFullPathByHash($this->hash);

        if (file_exists($path)) {
            unlink($path);
        }
        return parent::beforeDelete();
    }

    /**
     * @inheritdoc
     * @return UploadsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UploadsQuery(get_called_class());
    }

    /**
     * @param $width
     * @param $height
     * @param $mode
     * @return string
     */
    public function getThumbnail($width, $height, $mode = ManipulatorInterface::THUMBNAIL_OUTBOUND)
    {
        return Yii::$app->uploads->getThumbnail($this->hash, $width, $height, $mode);
    }
    /**
     * @param $mode
     * @return string
     */
    public function getImage()
    {
        return Yii::$app->uploads->getThumbnail($this->hash);
    }
    /**
     * @return boolean
     */
    public function fileExists()
    {
        return file_exists(Yii::$app->uploads->getFullPathByHash($this->hash));
    }

    /**
     * @param UploadedFile $file
     * @return string
     */
    private function getHash(UploadedFile $file)
    {
        $str = $file->name . $file->extension . $file->size . time() . rand();
        //$hexadecimal = hash('sha256', $str);
        //return base_convert($hexadecimal, 16, 36);
        return md5($str);
    }
}
