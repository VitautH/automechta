<?php

namespace common\controllers\actions;

use \yii\base\InvalidConfigException;
use \yii\base\InvalidValueException;
use \Yii;
use \yii\db\ActiveRecord;

class LoadTreeAction extends \yii\base\Action
{
    public $modelName;

    public $rootCondition = ['depth' => '0'];

    public $nameAttribute = 'name';

    public $nodeTypeResolver;

    public function run($id, $recursive = false)
    {
        if ($this->modelName === null) {
            throw new InvalidConfigException(get_class($this) . ' must define a "$modelName" parameter.');
        }

        /* response will be in JSON format */
        Yii::$app->response->format = 'json';

        $id = $this->controller->getNodeId($id);

        $models = ($id === '#') ? $this->getModel() : $this->getModel($id);

        $result = [];

        foreach ($models as $model) {
            $result[] = $this->getNodeData($model, $recursive);
        }

        return $result;
    }

    /**
     * @param ActiveRecord $model
     * @param bool $recursive
     * @return array
     */
    private function getNodeData(ActiveRecord $model, $recursive = false)
    {
        $children = $this->nodeHasChildren($model);

        if ($recursive && $children) {
            $children = [];
            $childrenModels = $this->getModel($model->id);
            foreach ($childrenModels as $child) {
                $children[] = $this->getNodeData($child, $recursive);
            }
        }

        $data = [
            'children' => $children,
            'id' => strtolower($model->formName()) . '_' . $model->id,
            'text' => $this->getNodeName($model),
            'type' => $this->getNodeType($model),
        ];

        return $data;
    }

    /**
     * @param ActiveRecord $model
     * @return mixed|string
     */
    private function getNodeName(ActiveRecord $model)
    {
        $result = '';

        if (is_callable($this->nameAttribute)) {
            $result = call_user_func($this->nameAttribute, $model);
        } else if(gettype($this->nameAttribute) === 'string') {
            $result = $model->{$this->nameAttribute};
        }

        return $result;
    }

    /**
     * @param ActiveRecord $model
     * @return mixed|string
     */
    private function getNodeType(ActiveRecord $model)
    {
        if (is_callable($this->nodeTypeResolver)) {
            $result = call_user_func($this->nodeTypeResolver, $model);
        } else if (gettype($this->nodeTypeResolver) === 'string') {
            $result = $model->{$this->nodeTypeResolver};
        } else {
            $result = $this->nodeHasChildren($model) ? 'root' : 'leaf';
        }

        return $result;
    }

    /**
     * @param ActiveRecord $model
     * @return bool
     */
    private function nodeHasChildren(ActiveRecord $model)
    {
        $child = $model->leaves()->limit(1)->one();
        return $child !== null;
    }

    /**
     * @param null $id
     * @return \yii\db\ActiveRecord[]
     * @throws InvalidValueException
     */
    private function getModel($id = null)
    {
        $query = Yii::createObject('yii\db\ActiveQuery',  [$this->modelName]);

        if ($id === null) {
            $models = $query->where($this->rootCondition)->orderBy('lft ASC')->all();
        } else {
            $parent = $query->where(['id' => $id])->limit(1)->one();
            if ($parent === null) {
                throw new InvalidValueException(get_class($this) . " record with id {$id} not found");
            }
            $models = $parent->children(1)->all();
        }

        return $models;
    }
}