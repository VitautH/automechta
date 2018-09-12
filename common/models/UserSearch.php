<?php

namespace common\models;

use yii\data\ActiveDataProvider;
use common\models\behaviors\DateRangeSearchBehavior;

class UserSearch extends User
{
    const SCENARIO_SEARCH = 'search';

    public function init()
    {
        $this->setScenario(self::SCENARIO_SEARCH);
        parent::init();
    }

    public function rules()
    {
        return [
            [['username'], 'string', 'max' => 255],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_SEARCH] = [
            'username',
            'id',
            'first_name',
            'last_name',
            'email',
            'phone',
            'phone_2',
            'created_at',
            'updated_at',
            '!auth_key',
            '!password_hash',
            '!password_reset_token'
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

    /**
     * return attribute label with ellipsis.
     * @param string $attribute the attribute name
     * @return string
     */
    public function getAttributeLabel($attribute)
    {
        return parent::getAttributeLabel($attribute) . '...';
    }

    public function search($params)
    {
        $query = User::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        // load the search form data and validate
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $this->fillDateRangeAttributes($query);

        // adjust the query by adding the filters
        $query->andFilterWhere(['like', 'username', $this->username])
             ->andFilterWhere(['id'=> $this->id])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'phone_2', $this->phone_2]);

        return $dataProvider;
    }
}