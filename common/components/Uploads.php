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
use Imagine\Exception\InvalidArgumentException;

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
        $query = (new Query())->select('server, id, hash, name, extension, type')->from('uploads');

        $query->andWhere(['linked_table' => $tableName]);

        if (!$model->isNewRecord && is_numeric($model->id)) {
            $query->andWhere(['linked_id' => $model->id]);
        } else {
            $query->andWhere(['linked_id' => null]);
            $query->andWhere(['created_by' => $userId]);
        }

        $data = $query->all();

        foreach ($data as &$item) {

            $item['path'] = $this->getFolderUrlByHash($item['hash'], $item['server']) . '/' . $item['hash'] . '.' . $item['extension'];
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
        $query = (new Query())->select('server,id, hash, name, extension, type')->from('uploads');
        $query->andWhere(['linked_table' => $linkedTable]);
        $query->andWhere(['linked_id' => $linkedId]);
        if ($userId !== null) {
            $query->andWhere(['created_by' => $linkedTable]);
        }
        $data = $query->all();
        foreach ($data as &$item) {
            $item['path'] = $this->getFolderUrlByHash( $item['hash']) . '/' . $item['hash'] . '.' . $item['extension'];
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
        $path = $hashDir . DIRECTORY_SEPARATOR . $hash . '.' . $model->extension;
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
    public function getFolderUrlByHash($hash, $server = null)
    {
        if ($server === null) {
            $url = 'https://www.automechta.by/uploads/' . substr($hash, 0, 1)
                . '/' . substr($hash, 1, 1)
                . '/' . substr($hash, 2, 1);
            return $url;
        } else {
            $url = 'http://' . $server . '/' . substr($hash, 0, 1)
                . '/' . substr($hash, 1, 1)
                . '/' . substr($hash, 2, 1);
            return $url;
        }
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

           try {
               Image::thumbnail($fullPath, $width, $height, ManipulatorInterface::THUMBNAIL_INSET)
                   ->save($fullPath, ['quality' => 85]);
           }
           catch (InvalidArgumentException $e){

           }
        }
    }

    /**
     * @param $hash
     * @param integer $width
     * @param integer $height
     * @param string $mode
     * @return url
     */
    public function getThumbnail($hash,$server = null, $width = 1920, $height = 800)
    {
        $model = $this->getModelByHash($hash);
        if ($model === null) {
            return false;
        }

        $fullPath = $this->getFullPathByHash($hash);
        if ($server == null) {
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
                $this->thumbnail($fullPath, $width, $height)
                    ->save($thumbnailPath, ['quality' => 85]);
            }

            return $this->getFolderUrlByHash($hash) . '/' . $width . 'x' . $height . '/' . $hash . '.' . $model->extension;
        } else {
            return $this->getFolderUrlByHash($hash, $server) . '/' . $width . 'x' . $height . '/' . $hash . '.' . $model->extension;
        }
    }

    public function getThumbnailTest($hash,$server = null, $width = 1920, $height = 800)
    {
        $model = $this->getModelByHash($hash);

        $fullPath = $this->getFullPathByHash($hash);

            $dir = dirname($fullPath);
            $filename = basename($fullPath);

        return $thumbnailPath = $dir . DIRECTORY_SEPARATOR . $width . 'x' . $height . DIRECTORY_SEPARATOR . $filename;



          //  return $this->getFolderUrlByHash($hash) . '/' . $width . 'x' . $height . '/' . $hash . '.' . $model->extension;

    }
    /**
     * @param $hash
     * @param string $mode
     * @return url
     */
    public function getFullImage($hash,$server = null)
    {
        $model = $this->getModelByHash($hash);
        if ($model === null) {
            return false;
        }

        $fullPath = $this->getFullPathByHash($hash);
        if ($server == null) {
            if (!$this->isImage($fullPath)) {
                return false;
            }

            $dir = dirname($fullPath);
            $filename = basename($fullPath);

            $imagePath = $dir . DIRECTORY_SEPARATOR . $filename;

            if (!file_exists($imagePath)) {
                return false;
            }

            return $this->getFolderUrlByHash($hash) . '/'. $hash . '.' . $model->extension;
        } else {
            return $this->getFolderUrlByHash($hash, $server) . '/'. $hash . '.' . $model->extension;
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
    protected function thumbnail($filename, $width, $height)
    {
        ini_set('memory_limit', -1);
        $box = new Box($width, $height);
        $img = Image::getImagine()->open(Yii::getAlias($filename));

        $img = $img->thumbnail($box);

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
