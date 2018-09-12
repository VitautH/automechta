<?php

namespace common\models;

use Yii;
use yii\data\ActiveDataProvider;
use common\models\behaviors\DateRangeSearchBehavior;

/**
 *
 */
class CreditApplicationSearch extends CreditApplication
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
            'status',
            'name',
            'phone',
            'firstname',
            'lastname',
            'product',
            'updated_at',
            'created_at',
            'date_arrive',
            'is_arrive',
        ];

        return $scenarios;
    }

    public function behaviors()
    {
        $behaviors =  parent::behaviors();
        $behaviors[] = [
            'class' => DateRangeSearchBehavior::className()
        ];
        return $behaviors;
    }

    public function search($params = null)
    {
        $query = CreditApplication::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if ($params !== null) {
            $this->load($params);
        }

        $this->fillDateRangeAttributes($query);
        $query->andFilterWhere(['firstname' => $this->firstname]);
        $query->andFilterWhere(['name' => $this->name]);
        $query->andFilterWhere(['lastname' => $this->lastname]);
        $query->andFilterWhere(['status' => $this->status]);
        $query->andFilterWhere(['phone' => $this->phone]);
        $query->andFilterWhere(['is_arrive' => $this->is_arrive]);
        if(!empty($this->date_arrive)) {
            $query->andFilterWhere(['date_arrive' => CreditApplication::dateToUnix($this->date_arrive)]);
        }
        
        return $dataProvider;
    }
}
