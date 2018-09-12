<?php

namespace common\models\behaviors;

use \Yii;
use yii\base\Behavior;
use common\models\Uploads;

/**
 * @author Aleh Hutnikau <goodnickoff@gmail.com>
 */
class UploadsBehavior extends Behavior
{
    /**
     * @var array
     */
    public $thumbnails = [];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
    }

    public function getUploads($type = null)
    {
        $linkedTable = $this->owner->tableName();
        $linkedId = $this->owner->id;
        $query =  Uploads::find()->where('linked_table=:linked_table AND linked_id=:linked_id', [
            ':linked_table' => $linkedTable,
            ':linked_id' => $linkedId,
        ]);

        if ($type !== null) {
            $query->andWhere('type='.$type);
        }
        return $query->all();
    }

    /**
     * @return bool
     */
    public function hasTitleImage()
    {
        return count($this->getUploads()) > 0;
    }

    /**
     * @param int $width
     * @param int $height
     * @return mixed
     */
    public function getTitleImageUrl($width = 1920, $height = 800)
    {
        $result = Yii::$app->uploads->getDummyImageUrl();
        $uploads = $this->getUploads(Uploads::TYPE_TITLE);
        if (empty($uploads)) {
            $uploads = $this->getUploads();
        }
        // && $uploads[0]->fileExists()
        if (!empty($uploads)) {
            $result = Yii::$app->uploads->getThumbnail($uploads[0]->hash, $uploads[0]->server,$width, $height);
        }
        return $result;
    }

    /**
     * @param int $width
     * @param int $height
     * @return mixed
     */
    public function getTitleImage($width = 1920, $height = 800)
    {
        $result = Yii::$app->uploads->getDummyImageUrl();
        $uploads = $this->getUploads(Uploads::TYPE_TITLE);
        if (empty($uploads)) {
            $uploads = $this->getUploads();
        }
        //&& $uploads[0]->fileExists()
        if (!empty($uploads)) {
            $result = Yii::$app->uploads->getThumbnail($uploads[0]->hash,$uploads[0]->server, $width, $height);
        }
        return $result;
    }

    /**
     * @param int $width
     * @param int $height
     * @return mixed
     */
    public function getFullImage()
    {
        $result = Yii::$app->uploads->getDummyImageUrl();
        $uploads = $this->getUploads(Uploads::TYPE_TITLE);
        if (empty($uploads)) {
            $uploads = $this->getUploads();
        }
        //&& $uploads[0]->fileExists()
        if (!empty($uploads)) {
            $result = Yii::$app->uploads->getFullImage($uploads[0]->hash,$uploads[0]->server);
        }
        return $result;
    }
}
