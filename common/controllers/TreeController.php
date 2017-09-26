<?php

namespace common\controllers;

use \Yii;

class TreeController extends \yii\web\Controller
{

    /**
     * @var string model class
     */
    public $modelName;

    /**
     * @var string model class
     */
    private $model;

    /**
     * @return array
     */
    public function actions()
    {
        return [
            'load-tree' => [
                'class' => 'common\controllers\actions\LoadTreeAction',
                'modelName' => $this->modelName,
                'rootCondition' => ['depth' => 1],
                'nameAttribute' => function ($model) {return $model->i18n()->name;},
            ],
            'move-node' => [
                'class' => 'common\controllers\actions\MoveNodeAction',
                'modelName' => $this->modelName,
            ],
        ];
    }

    /**
     * @param $id
     * @return mixed
     * @throws InvalidConfigException
     */
    public function getNodeId($id)
    {
        if ($this->model === null) {
            $this->model = $query = Yii::createObject($this->modelName);
        }
        return str_replace(strtolower($this->model->formName()) . '_', '', $id);
    }

}