<?php

namespace backend\models;

use yii\base\Model;
use common\models\AutoModifications;
use yii\data\ActiveDataProvider;
use common\models\AutoMakes;
use common\models\AutoModels;

class ModificationsSearch extends AutoModifications
{
    const SCENARIO_SEARCH = 'search';


    public function init()
    {
        $this->setScenario(self::SCENARIO_SEARCH);
        parent::init();
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_SEARCH] = [
            'id',
            'model_id',
            'make_id',
            'modification_name',
            'yearFrom',
            'yearTo',
        ];

        return $scenarios;
    }


    public function search($params = null)
    {
        $query = AutoModifications::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);


        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['id' => $this->id]);

        if ($this->make_id != 0) {
            $query->andFilterWhere(['make_id' => $this->make_id]);
        }
        if ($this->model_id != 0){
            $query->andFilterWhere(['model_id' => $this->model_id]);
        }

        if ($this->modification_name != 0) {
            $query->andFilterWhere(['like','modification_name', $this->modification_name]);
        }
        if ($this->yearFrom != 0){
            $query->andFilterWhere(['>=','yearFrom', $this->yearFrom]);
        }
        if ($this->yearTo != 0){

            $query->andFilterWhere(['<=','yearTo', $this->yearTo]);
        }

        return $dataProvider;
    }

    /**
     * @return array
     */
    public static function getMakesAll()
    {
        $makes = array();
        foreach (AutoMakes::find()->all() as $make) {
            $makes[$make->id] = $make->name;
        }

        return $makes;
    }

    /**
     * @return array
     */
    public static function getModelsAll()
    {
        $models = array();
        foreach (AutoModels::find()->all() as $model) {
            $models[$model->id] = $model->model;
        }

        return $models;
    }

    /**
     * @return array
     */
    public static function getModels($id)
    {
        $models = array();
        foreach (AutoModels::find()->where(['make_id'=>$id])->all() as $model) {
            $models[$model->id] = $model->model;
        }

        return $models;
    }

    /**
     * @return array
     */
    public static function getYears()
    {
        $minYear = AutoModifications::find()->select('yearFrom')->where(['not', ['yearFrom' => null]])->orderBy(['yearFrom' => SORT_ASC])->one();
        $currentYear = date('Y');
        $years = array();

        for ($year = $minYear->yearFrom; $year <= $currentYear; $year++) {
            $years[$year] = $year;
        }

        return $years;
    }
}