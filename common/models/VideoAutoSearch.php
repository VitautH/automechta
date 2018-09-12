<?php

namespace common\models;

use Yii;
use yii\data\ActiveDataProvider;

class VideoAutoSearch extends ProductVideo
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
            'product_type',
            'product_make',
            'product_id',
            'year',
            'model',
            'video_url',
        ];

        return $scenarios;
    }


    public function search($params = null)
    {
        $query = ProductVideo::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        if ($params !== null) {
            $this->load($params);
        }
        $query->FilterWhere(['product_id' => $this->product_id]);
        $query->FilterWhere(['product_type' => $this->product_type]);
        $query->FilterWhere(['video_url' => $this->video_url]);
        if ($this->product_make != 0) {
            $query->andFilterWhere(['year' => $this->year]);
            $query->andFilterWhere(['like', 'model', $this->model]);
            $query->andFilterWhere(['product_make' => $this->product_make]);
        }
        else {
            $query->FilterWhere(['year' => $this->year]);
            $query->FilterWhere(['like', 'model', $this->model]);
        }

        return $dataProvider;
    }
}