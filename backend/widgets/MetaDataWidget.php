<?php

namespace backend\widgets;

use common\models\MetaData;
use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\helpers\Html;
use yii\db\ActiveRecord;

class MetaDataWidget extends Widget
{
    /**
     * @var ActiveRecord
     */
    public $model;

    /**
     * @var string
     */
    public $language;

    /**
     * @throws InvalidConfigException
     */
    public function init()
    {
        parent::init();
        if ($this->model === null) {
            throw new InvalidConfigException('`model` property was not specified');
        }
        if ($this->language === null) {
            throw new InvalidConfigException('`language` property was not specified');
        }
    }

    /**
     * @return string
     */
    public function run()
    {
        $metadataModels = MetaData::getModels($this->model);

        return $this->render('metadata/index', [
            'model' => $this->model,
            'metadataModels' => $metadataModels,
            'language' => $this->language,
        ]);
    }

}