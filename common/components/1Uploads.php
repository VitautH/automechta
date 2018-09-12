<?php

namespace common\components;

use Yii;
use yii\base\Component;
use yii\db\ActiveRecord;
use common\models\Uploads as UploadsModel;
use yii\db\Query;
use yii\imagine\Image;
use Imagine\Image\Box;
use Imagine\Image\ManipulatorInterface;
use Imagine\Image\Point;
use Imagine\Image\Color;

/**
 * Class Uploads
 *
 * Service for managing uploaded files
 *
 * @package common\components
 */
class Uploads extends Component
{

    private $models = [];
    // ToDo: считывать с базы данных!
    const SERVER_CDN = 'http://178.159.45.191';
    const KEY = '5ccee5ce1b993bd17b6a12cd2d613b0a';
    const STATIC_SERVER = '10.1.1.15';

    /**
     * Uploads constructor.
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        parent::__construct($config);
    }

    /**
     * @return bool|string
     */
    public function getDummyImageUrl()
    {
        return $hashDir = \Yii::getAlias('/theme/images/dummy.png');
    }

    /**
     * Get uploads of passed model in the following format:
     * [
     *  'id' => '341',
     *  'hash' => 'g7i9hbhzeosks448ws0w0k4cw08c8kwwkgwskw8kw4c0o00c',
     *  'name' => 'technics-q-c-800-600-6.jpg',
     *  'path' => '/uploads/1/7/17g7i9hbhzeosks448ws0w0k4cw08c8kwwkgwskw8kw4c0o00c.jpg',
     * ]
     * @param ActiveRecord $model
     * @param null|integer $userId
     * @return array
     */
    public function getUploadsDataByModel(ActiveRecord $model, $userId = null)
    {
        $tableName = $model->tableName();
        if ($userId === null) {
            $userId = Yii::$app->user->id;
        }
        $query = (new Query())->select('id, hash, name, extension, type')->from('uploads');

        $query->andWhere(['linked_table'=>$tableName]);

        if (!$model->isNewRecord && is_numeric($model->id)) {
            $query->andWhere(['linked_id' => $model->id]);
        } else {
            $query->andWhere(['linked_id' => null]);
            $query->andWhere(['created_by' => $userId]);
        }

        $data = $query->all();

        foreach ($data as &$item) {
            $item['path'] = '/'.$this->getFolderUrlByHash($item['hash']) . '/' . $item['hash'] . '.' . $item['extension'];
        }
        
        return $data;
    }
    /**
     * Get uploads of passed model in the following format:
     * [
     *  'id' => '341',
     *  'hash' => 'g7i9hbhzeosks448ws0w0k4cw08c8kwwkgwskw8kw4c0o00c',
     *  'name' => 'technics-q-c-800-600-6.jpg',
     *  'path' => '/uploads/1/7/17g7i9hbhzeosks448ws0w0k4cw08c8kwwkgwskw8kw4c0o00c.jpg',
     * ]
     * @param ActiveRecord $model
     * @param null|integer $userId
     * @return array
     */
    public function getUploadsDataByModelCdn(ActiveRecord $model, $userId = null)
    {
        $tableName = $model->tableName();
        if ($userId === null) {
            $userId = Yii::$app->user->id;
        }
        $query = (new Query())->select('id, hash, name, extension, type')->from('uploads');

        $query->andWhere(['linked_table'=>$tableName]);

        if (!$model->isNewRecord && is_numeric($model->id)) {
            $query->andWhere(['linked_id' => $model->id]);
        } else {
            $query->andWhere(['linked_id' => null]);
            $query->andWhere(['created_by' => $userId]);
        }

        $data = $query->all();

        foreach ($data as &$item) {
            $item['path'] = $this->getFolderUrlByHashCdn($item['hash']) . '/' . $item['hash'] . '.' . $item['extension'];
        }

        return $data;
    }
    /**
     * Get uploads in the following format:
     * [
     *  'id' => '341',
     *  'hash' => 'g7i9hbhzeosks448ws0w0k4cw08c8kwwkgwskw8kw4c0o00c',
     *  'name' => 'technics-q-c-800-600-6.jpg',
     *  'path' => '/uploads/1/7/17g7i9hbhzeosks448ws0w0k4cw08c8kwwkgwskw8kw4c0o00c.jpg',
     * ]
     * @param string $linkedTable
     * @param integer $linkedId
     * @param integer $userId
     * @return array
     */
    public function getUploadsData($linkedTable, $linkedId, $userId = null)
    {
        $query = (new Query())->select('id, hash, name, extension, type')->from('uploads');
        $query->andWhere(['linked_table'=>$linkedTable]);
        $query->andWhere(['linked_id' => $linkedId]);
        if ($userId !== null) {
            $query->andWhere(['created_by' => $linkedTable]);
        }
        $data = $query->all();
        foreach ($data as &$item) {
            $item['path'] = $this->getFolderUrlByHash($item['hash']) . '/' . $item['hash'] . '.' . $item['extension'];
        }
        return $data;
    }



    /**
     * @param string $hash
     * @return string
     */
    public function getFullPathByHash($hash)
    {
        $hashDir = $this->getFolderPathByHash($hash);
        $model = $this->getModelByHash($hash);
        $path = $hashDir. DIRECTORY_SEPARATOR . $hash . '.' . $model->extension;
        return $path;
    }

    /**
     * Get path to file by hash
     * @param string $hash
     * @return string
     */
    public function getFolderPathByHash($hash)
    {
        $hashDir = \Yii::getAlias('@frontend/web/uploads');
        $hashDir .= DIRECTORY_SEPARATOR . substr($hash, 0, 1)
            . DIRECTORY_SEPARATOR . substr($hash, 1, 1)
            . DIRECTORY_SEPARATOR . substr($hash, 2, 1);

        return $hashDir;
    }

    /**
     * Get url to folder by hash
     * @return string
     */
    public function getFolderUrlByHash($hash)
    {
        $url = '/uploads/' . substr($hash, 0, 1)
            . '/' . substr($hash, 1, 1)
            . '/' . substr($hash, 2, 1);
        return $url;
    }
    /**
     * Get url to folder by hash
     * @return string
     */
    //ToDo: передавать адресс сервера статики
    public function getFolderUrlByHashCdn($hash, $cdnServer= null)
    {
        $url = static::SERVER_CDN.'/' . substr($hash, 0, 1)
            . '/' . substr($hash, 1, 1)
            . '/' . substr($hash, 2, 1);

        return $url;
    }
    /**
     * @param $hash
     * @param integer $width
     * @param integer $height
     * @return bool
     */
    public function limitSize($hash, $width = 1920, $height = 800)
    {
        $model = $this->getModelByHash($hash);
        if ($model === null) {
            return false;
        }

        $fullPath = $this->getFullPathByHash($hash);

        if (!$this->isImage($fullPath)) {
            return false;
        }

        $img = Image::getImagine()->open($fullPath);
        $size = $img->getSize();

        if ($size->getWidth() > $width || $size->getHeight() > $height) {
            if ($size->getWidth() > $width) {
                $rate = $width / $size->getWidth();
            } else {
                $rate = $height / $size->getHeight();
            }
            $width = intval($size->getWidth() * $rate);
            $height = intval($size->getHeight() * $rate);

            Image::thumbnail($fullPath, $width, $height, ManipulatorInterface::THUMBNAIL_INSET)
                ->save($fullPath, ['quality' => 85]);
        }
    }

    /**
     * @param $hash
     * @param integer $width
     * @param integer $height
     * @param string $mode
     * @return url
     */
    public function getThumbnail($hash, $width = 1920, $height = 800, $mode = ManipulatorInterface::THUMBNAIL_OUTBOUND)
    {
        $model = $this->getModelByHash($hash);
        if ($model === null) {
            return false;
        }

        $fullPath = $this->getFullPathByHash($hash);
        if (!$this->isImage($fullPath)) {
            return false;
        }

        $dir = dirname($fullPath);
        $filename = basename($fullPath);

        $thumbnailPath = $dir . DIRECTORY_SEPARATOR . $width . 'x' . $height . DIRECTORY_SEPARATOR . $filename;

        if (!file_exists($thumbnailPath)) {
            if (!file_exists($thumbnailPath) && !is_dir(dirname($thumbnailPath))) {
                mkdir(dirname($thumbnailPath), 0755, true);
            }
            $this->thumbnail($fullPath, $width, $height, $mode)
                ->save($thumbnailPath, ['quality' => 85]);
        }

        return $this->getFolderUrlByHash($hash) . '/' . $width . 'x' . $height . '/' . $hash . '.' . $model->extension;
    }

    /**
     * @param $hash
     * @param integer $width
     * @param integer $height
     * @param string $mode
     * @return url
     */
    // ToDo: Thumbnail width && height
    public function getThumbnailCdn($hash, $width = 1920, $height = 800, $mode = ManipulatorInterface::THUMBNAIL_OUTBOUND)
    {
        $model = $this->getModelByHash($hash);
        if ($model === null) {
            return false;
        }
        return  $this->getFolderUrlByHashCdn($hash) . '/'. $hash . '.' . $model->extension;

//        $fullPath = $this->getFullPathByHash($hash);
//
//        //ToDo: isImage!
////        if (!$this->isImage($fullPath)) {
////            return false;
////        }
//
//        $dir = dirname($fullPath);
//        $filename = basename($fullPath);
//        $url = $this->getFolderUrlByHashCdn($hash) . '/' . $width . 'x' . $height . '/' . $hash . '.' . $model->extension;
//        $urlHeaders = @get_headers($url);
//// проверяем ответ сервера на наличие кода: 200 - ОК
//        if(strpos($urlHeaders[0], 200)){
//            return $url;
//        }
//        else {
//            return 'http://178.159.45.191/7/9/6/796df5e3b9f07edea2f9adc6e8e2ef7c.jpg';
//            $url = static::STATIC_SERVER . '/Uploads.php?action=thumb';
//
//            $post = ['key' => static::KEY, 'hash' => $hash, 'width' => $width, 'height' => $height];
//            $ch = curl_init($url);
//            curl_setopt($ch, CURLOPT_URL, $url);
//            curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
//            curl_setopt($ch, CURLOPT_POST, 1);
//            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
//            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//            $result = curl_exec($ch);
//
//            if (curl_errno($ch) == 0) {
//                curl_close($ch);
//                if ($result == '1'){
//                    return  $this->getFolderUrlByHashCdn($hash) . '/' . $width . 'x' . $height . '/' . $hash . '.' . $model->extension;
//                }
//                else {
//                    return false;
//                }
//
//            } else {
//                curl_close($ch);
//                return false;
//            }
//        }
       // $thumbnailPath = $dir . DIRECTORY_SEPARATOR . $width . 'x' . $height . DIRECTORY_SEPARATOR . $filename;

//        if (!file_exists($thumbnailPath)) {
//            if (!file_exists($thumbnailPath) && !is_dir(dirname($thumbnailPath))) {
//                mkdir(dirname($thumbnailPath), 0755, true);
//            }
//            $this->thumbnail($fullPath, $width, $height, $mode)
//                ->save($thumbnailPath, ['quality' => 85]);
//        }


    }

    public function rotateCdn($hash, $deg, $serverCdn = null){
        $model = $this->getModelByHash($hash);
        $file =  $hash . '.' . $model->extension;

        $url = static::STATIC_SERVER . '/Uploads.php?action=rotate';

        $post = ['key' => static::KEY, 'hash' => $hash, 'path' => $file, 'deg' => $deg];
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);

        if (curl_errno($ch) == 0) {
            curl_close($ch);
            if ($result == '1'){
                return true;
            }
            else {
                return false;
            }

        } else {
            curl_close($ch);
            return false;
        }
    }
    /**
     * @param $hash
     * @param integer $width
     * @param integer $height
     * @return bool
     */
    public function resize($hash, $width = 1920, $height = 800)
    {
        $model = $this->getModelByHash($hash);
        if ($model === null) {
            return false;
        }

        $fullPath = $this->getFullPathByHash($hash);

        if (!$this->isImage($fullPath)) {
            return false;
        }

        $dir = dirname($fullPath);
        $filename = basename($fullPath);

        $thumbnailPath = $dir . DIRECTORY_SEPARATOR . $width . 'x' . $height . DIRECTORY_SEPARATOR . $filename;

        if (!file_exists($thumbnailPath)) {
            if (!file_exists($thumbnailPath) && !is_dir(dirname($thumbnailPath))) {
                mkdir(dirname($thumbnailPath), 0755, true);
            }
            $image = Image::getImagine()->open($fullPath);
            $image->resize(new Box($width, $height))
                ->save($thumbnailPath, ['quality' => 85]);
        }

        return $this->getFolderUrlByHash($hash) . '/' . $width . 'x' . $height . '/' . $hash . '.' . $model->extension;
    }

    /**
     * @param string $hash
     * @return UploadsModel
     */
    public function getModelByHash($hash)
    {
        if (!isset($this->models[$hash])) {
            $this->models[$hash] = UploadsModel::find()->where(['hash' => $hash])->one();
        }
        return $this->models[$hash];
    }

    /**
     * @param $path
     * @return bool
     */
    public function isImage($path)
    {
        if (file_exists($path) && @is_array(getimagesize($path))) {
            $image = true;
        } else {
            $image = false;
        }
        return $image;
    }

    /**
     * @param $filename
     * @param $width
     * @param $height
     * @param string $mode
     * @return mixed
     */
    protected function thumbnail($filename, $width, $height, $mode = ManipulatorInterface::THUMBNAIL_INSET)
    {
        ini_set('memory_limit', -1 );
        $box = new Box($width, $height);
        $img = Image::getImagine()->open(Yii::getAlias($filename));

        $img = $img->thumbnail($box, $mode);

        // create empty image to preserve aspect ratio of thumbnail
        $thumb = Image::getImagine()->create($box, new Color('FFF', 100));

        // calculate points
        $size = $img->getSize();

        $startX = 0;
        $startY = 0;
        if ($size->getWidth() < $width) {
            $startX = ceil($width - $size->getWidth()) / 2;
        }
        if ($size->getHeight() < $height) {
            $startY = ceil($height - $size->getHeight()) / 2;
        }

        $thumb->paste($img, new Point($startX, $startY));

        return $thumb;
    }
}
