<?php

namespace common\controllers\behaviors;

use Yii;
use yii\base\Behavior;
use common\models\Uploads;
use yii\db\ActiveRecord;

/**
 * @author Aleh Hutnikau <goodnickoff@gmail.com>
 */
class UploadsBehavior extends Behavior
{

    /**
     * @param ActiveRecord $model
     * @return boolean
     */
    public function saveUploads(ActiveRecord $model)
    {
        if ($model->isNewRecord) {
            return false;
        }

        $tableName = $model->tableName();
        $uploadsIds = Yii::$app->request->post('Uploads');

        if (!is_array($uploadsIds)) {
            $uploadsIds = [];
        }

        $toAttach = array_values($uploadsIds);

        if (!is_array($toAttach)) {
            $toAttach = [];
        }

        $previouslyLoaded = Uploads::find()->where(
            ['linked_table' => $tableName, 'linked_id' => $model->id]
        )->indexBy('id')->all();

        $toDelete = array_diff(array_keys($previouslyLoaded), $toAttach);

        foreach ($toDelete as $deleteId) {
            $uploadsModel = Uploads::findOne($deleteId);
            if ($uploadsModel !== null) {
                $uploadsModel->delete();
            }
        }

        Yii::$app->db->createCommand()->update(
            'uploads',
            ['linked_id' => $model->id, 'type' => Uploads::TYPE_REGULAR],
            ['in', 'id', $toAttach]
        )->execute();

        if (isset($uploadsIds['title']) && in_array($uploadsIds['title'], $toAttach)) {
            $this->setTitle($uploadsIds['title']);
        }
    }

    /**
     * @param $id
     * @throws \yii\db\Exception
     */
    public function setTitle($id)
    {
        Yii::$app->db->createCommand()->update(
            'uploads',
            ['type' => Uploads::TYPE_TITLE],
            'id=:id',
            [':id' => $id]
        )->execute();
    }

}
