<?php

namespace common\models\behaviors;

use yii\base\Behavior;
use \Yii;
use yii\db\ActiveRecord;
use yii\db\ActiveQuery;
use yii\data\ActiveDataProvider;

class I18nBehavior extends Behavior
{
    public $i18nModel;

    /**
     * @var string
     */
    private $postfix = 'I18n';

    /**
     * List of related models
     * @var array
     */
    private $models = [];

    /**
     * @param null $lang
     * @return \yii\base\Model
     */
    public function i18n($lang = null)
    {
        if ($lang === null) {
            $lang = Yii::$app->language;
        }

        $modelName = $this->getModelName();

        if (!isset($this->models[$lang]) && !$this->owner->isNewRecord) {
            $this->models[$lang] = call_user_func($modelName . '::find')
                ->where(['parent_id' => $this->owner->id, 'language' => $lang])->one();
        }

        if (!isset($this->models[$lang]) || $this->models[$lang] === null) {
            $this->models[$lang] = new $modelName;
            $this->models[$lang]->language = $lang;
        }

        return $this->models[$lang];
    }

    /**
     * I18n Relation
     * @return \yii\db\ActiveQuery
     */
    public function getI18n()
    {
        return $this->owner->hasMany($this->getModelName(), ['parent_id' => 'id']);
    }

    /**
     * Function loads data for parent model and for language model
     * List of languages will be given from application parameter (`Yii::$app->params['i18n']`)
     *
     * @param array $data - data to be loaded
     * @return boolean
     */
    public function loadI18n($data)
    {
        $result = $this->owner->load($data);

        foreach (\Yii::$app->params['i18n'] as $key => $lang) {
            $i18nData = $this->getI18nData($data, $key);

            if ($i18nData !== null) {
                $result = $result && $this->i18n($key)->load($i18nData);
            }
        }
        return $result;
    }

    /**
     * @see \yii\base\Model::validate() for details.
     * @param null $attributeNames
     * @param bool $clearErrors
     * @return mixed
     */
    public function validateI18n($attributeNames = null, $clearErrors = true)
    {
        $result = $this->owner->validate($attributeNames, $clearErrors);

        foreach (\Yii::$app->params['i18n'] as $key => $lang) {
            $result = $this->i18n($key)->validate($attributeNames, $clearErrors) && $result;
        }

        return $result;
    }

    /**
     * @param null $params
     * @return ActiveDataProvider
     */
    public function searchI18n($params = null)
    {
        if (method_exists($this->owner, 'search')) {
            $dataProvider = $this->owner->search($params);
        } else {
            $dataProvider = new ActiveDataProvider([
                'query' => new ActiveQuery(get_class($this->owner)),
            ]);
        }

        $query = $dataProvider->query;

        $query->joinWith('i18n');
        $i18nModel = $this->i18n();

        if (empty($i18nModel->language)) {
            $i18nModel->language = Yii::$app->language;
        }

        $i18nAttributes = $this->getI18nAttributes();
        $i18nTableName = $i18nModel->tableName();

        $query->andWhere([$i18nTableName . '.language' => Yii::$app->language]);

        foreach ($i18nAttributes as $i18nAttribute) {
            $value = $i18nModel->getAttribute($i18nAttribute);
            if (!empty($value)) {
                $query->andFilterWhere(['like', $i18nTableName . '.' . $i18nAttribute, $value]);
            }
        }

        return $dataProvider;
    }

    /**
     * @see \yii\base\Model::getErrors() for details.
     * @param null $attribute
     * @return array
     */
    public function getErrorsI18n($attribute = null)
    {
        $result = $this->owner->getErrors($attribute);

        foreach (\Yii::$app->params['i18n'] as $key => $lang) {
            $i18nErrors = $this->i18n($key)->getErrors($attribute);
            if (!empty($i18nErrors)) {
                $result[$key] = $i18nErrors;
            }

        }
        return $result;
    }

    /**
     * get related models
     * @return \yii\base\Model[]
     */
    public function getI18nModels()
    {
        $result = [];
        foreach (\Yii::$app->params['i18n'] as $key => $lang) {
            $result[$key] = $this->i18n($key);
        }
        return $result;
    }

    /**
     * @return array
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'afterInsert',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterUpdate',
        ];
    }

    /**
     * Set `parent_id` parameter for related models after inserting new record
     */
    public function afterInsert()
    {
        $models = $this->getI18nModels();
        foreach ($models as $model) {
            $model->parent_id = $this->owner->id;
            $model->save();
        }
    }

    /**
     * Set `parent_id` parameter
     */
    public function afterUpdate()
    {
        $models = $this->getI18nModels();
        foreach ($models as $model) {
            $model->parent_id = $this->owner->id;
            $model->save();
        }
    }

    /**
     * Get name of 18n model
     * @return string
     */
    private function getModelName()
    {
        if ($this->i18nModel === null) {
            $this->i18nModel = get_class($this->owner) . $this->postfix;
        }
        return $this->i18nModel;
    }

    /**
     * Fetch language data from array
     * If owner model name is `Menu` and language model name is MenuI18n
     * then data will be fetched from `$data['MenuI18n'][$lang]`
     * or from $data[$lang] if former is not set.
     * @param array $data
     * @param string $lang
     * @return null|array
     */
    private function getI18nData($data, $lang)
    {
        $result = null;
        $model = $this->i18n($lang);
        $i18nFormName = $model->formName();
        if (isset($data[$i18nFormName][$lang])) {
            $result = [$i18nFormName => $data[$i18nFormName][$lang]];
        } else if (isset($data[$lang])) {
            $result = $data[$lang];
        }
        return $result;
    }

    /**
     * List of safe attributes from i18n model
     * @return \string[]
     */
    private function getI18nAttributes()
    {
        $model = $this->i18n();
        $result = $model->safeAttributes();
        unset($result['id']);
        unset($result['language']);
        unset($result['parent_id']);
        return $result;
    }
}