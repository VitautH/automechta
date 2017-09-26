<?php

namespace common\controllers\actions;

use \yii\base\InvalidConfigException;
use \yii\base\InvalidParamException;
use \Yii;

class MoveNodeAction extends \yii\base\Action
{
    public $modelName;

    public function run($id)
    {
        if ($this->modelName === null) {
            throw new InvalidConfigException(get_class($this) . ' must define a "$modelName" parameter.');
        }

        $lftSiblingId = Yii::$app->request->post('lftSiblingId', null);
        $rgtSiblingId = Yii::$app->request->post('rgtSiblingId', null);
        $parentId = Yii::$app->request->post('parentId', null);

        $id = $this->controller->getNodeId($id);
        $model = $this->getModel($id);

        /* response will be in JSON format */
        Yii::$app->response->format = 'json';

        if ($lftSiblingId !== null) {
            $lftSiblingId = $this->controller->getNodeId($lftSiblingId);
            $lftSiblingModel = $this->getModel($lftSiblingId);
            $model->insertAfter($lftSiblingModel);
        } else if ($rgtSiblingId !== null) {
            $rgtSiblingId = $this->controller->getNodeId($rgtSiblingId);
            $rgtSiblingModel = $this->getModel($rgtSiblingId);
            $model->insertBefore($rgtSiblingModel);
        } else if ($parentId !== null) {
            $parentId = $this->controller->getNodeId($parentId);
            $parentModel = $this->getModel($parentId);
            $model->appendTo($parentModel);
        } else {
            throw new InvalidParamException(get_class($this) . " at least one of following parameters must be represented: 'lftSiblingId', 'rgtSiblingId', 'parentId'");
        }

        return ['status' => 'success'];
    }

    /**
     * @param null $id
     * @return \yii\db\ActiveRecord[]
     * @throws InvalidValueException
     */
    private function getModel($id = null)
    {
        $query = Yii::createObject('yii\db\ActiveQuery',  [$this->modelName]);
        $model = $query->where(['id' => $id])->limit(1)->one();
        return $model;
    }
}