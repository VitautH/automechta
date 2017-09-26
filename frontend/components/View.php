<?php

namespace frontend\components;

use common\models\MetaData;
use common\models\Menu;

class View extends \yii\web\View
{
    /**
     * @param MetaData[] $metaData
     */
    public function registerMetaData(array $metaData = null)
    {
        if ($metaData === null) {
            $model = Menu::getCurrent();
            $metaData = MetaData::getModels($model);
        }

        $this->title = $metaData[MetaData::TYPE_TITLE]->i18n()->value;
        $this->registerMetaTag([
            'name' => 'description',
            'content' => $metaData[MetaData::TYPE_DESCRIPTION]->i18n()->value
        ]);
        $this->registerMetaTag([
            'name' => 'keywords',
            'content' => $metaData[MetaData::TYPE_KEYWORDS]->i18n()->value
        ]);
    }

}