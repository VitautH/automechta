<?php

namespace common\models;

use yii\data\ActiveDataProvider;
use common\models\behaviors\DateRangeSearchBehavior;

class AuthItemSearch extends AuthItem
{
    const SCENARIO_SEARCH = 'search';

    public function __construct(array $config = [])
    {
        $this->setScenario(self::SCENARIO_SEARCH);
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['type'], 'integer'],
            [['description', 'data'], 'string'],
            [['name', 'rule_name'], 'string', 'max' => 64]
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();

        $scenarios[self::SCENARIO_SEARCH] = ['name', 'description', 'rule_name', 'type', 'created_at', 'updated_at'];

        return $scenarios;
    }

    /**
     * return attribute label with ellipsis.
     * @param string $attribute the attribute name
     * @return string
     */
    public function getAttributeLabel($attribute)
    {
        return parent::getAttributeLabel($attribute) . '...';
    }

    public function behaviors()
    {
        $behaviors =  parent::behaviors();
        $behaviors[] = [
            'class' => DateRangeSearchBehavior::className()
        ];
        return $behaviors;
    }

    public function search()
    {
        $query = AuthItem::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->fillDateRangeAttributes($query);
        // adjust the query by adding the filters
        $query->andFilterWhere(['type' => $this->type])
              ->andFilterWhere(['like', 'name', $this->name])
              ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}