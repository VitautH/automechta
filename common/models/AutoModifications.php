<?php

namespace common\models;

use common\models\AutoSpecifications;
use common\models\AutoMakes;
use common\models\AutoModels;
use yii\db\Query;
use Yii;
use yii\web\UploadedFile;
use Imagine\Image\ManipulatorInterface;
use yii\imagine\Image;

class AutoModifications extends \yii\db\ActiveRecord
{
    /**
     * @var UploadedFile
     */
    public $imageFiles;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'auto_modifications';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['model_id', 'region_id', 'make_id', 'type_body'], 'integer'],
            [['model_id', 'region_id', 'make_id'], 'required'],
            [['modification_name', 'slug', 'years'], 'string'],
            [['imageFiles'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg', 'maxFiles' => 10],
        ];
    }

    public function upload($modifications_id)
    {
        $result = false;


        $dir = '/home/admin/web/automechta.by/public_html/frontend/web/uploads/modificationImg/' . $modifications_id;

        if (!file_exists($dir . DIRECTORY_SEPARATOR) && !is_dir($dir . DIRECTORY_SEPARATOR)) {
            mkdir($dir . DIRECTORY_SEPARATOR, 0755, true);
        }

        if ($this->validate()) {
            ini_set('memory_limit', -1);
            foreach ($this->imageFiles as $file) {
                $fileName = md5($file->baseName) . '.' . $file->extension;
                $path = $dir . DIRECTORY_SEPARATOR . $fileName;
                if ($file->saveAs($path)) {
                    $imageModification = new ImageModifications();
                    $imageModification->modifications_id = $modifications_id;
                    $imageModification->img_url = '/uploads/modificationImg/' . $modifications_id . DIRECTORY_SEPARATOR . $fileName;
                    if ($imageModification->save()) {
                        $result = array();
                        $result['status'] = 'success';
                        $result['path'] = $path;
                        $result['id'] = $imageModification->id;
                    }
                }
            }
        } else {
            return $this->getErrors();
        }
        return $result;
    }

    public function getUploadsImageModification($modificationsId)
    {

        $query = (new Query())->select('server, id, modifications_id, img_url')->from(ImageModifications::tableName());

        $query->andWhere(['modifications_id' => $modificationsId]);


        $data = $query->all();

        foreach ($data as &$item) {

            $item['path'] = $item['server'] . '/' . $item['img_url'];
        }

        return $data;
    }
}