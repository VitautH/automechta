<?php

namespace common\controllers\behaviors;

use Yii;
use yii\base\Behavior;
use common\models\MetaData;
use yii\db\ActiveRecord;

/**
 * @author Aleh Hutnikau <goodnickoff@gmail.com>
 */
class MetaDataBehavior extends Behavior
{

    /**
     * @param ActiveRecord $model
     * @return boolean
     */
    public function saveMetaData(ActiveRecord $model)
    {
        if ($model->isNewRecord) {
            return false;
        }

        $tableName = $model->tableName();

        $metaDataModels = MetaData::getModels($model);
        $data = Yii::$app->request->post('MetaDataI18n');

        foreach ($metaDataModels as $metaDataModel) {
            $metaDataModel->linked_table = $tableName;
            $metaDataModel->linked_id = $model->id;
            foreach(\Yii::$app->params['i18n'] as $langKey => $language) {
                if (isset($data[$metaDataModel->type][$langKey]['value'])) {
                    $metaDataModel->i18n($langKey)->value = $data[$metaDataModel->type][$langKey]['value'];
                } else {
                    $metaDataModel->i18n($langKey)->value = '';
                }
                $metaDataModel->save();
            }
        }

    }

}
