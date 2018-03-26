<?php

namespace common\models;

use Yii;
use yii\data\ActiveDataProvider;

class VideoAutoSearch extends VideoAuto
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
            'type_id',
            'make_id',
            'model',
            'video_url',
        ];

        return $scenarios;
    }


    public function search($params = null)
    {
        $query = VideoAuto::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        if ($params !== null) {
            $this->load($params);
        }

        $query->andFilterWhere(['type_id' => $this->type_id]);
        $query->andFilterWhere(['video_url' => $this->video_url]);
        $query->andFilterWhere(['like', 'model', $this->model]);
        if ($this->make_id != 0) {
            $query->andFilterWhere(['make_id' => $this->make_id]);
        }

        return $dataProvider;
    }
}