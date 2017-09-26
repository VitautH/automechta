<?php

namespace common\models;

use Yii;
use yii\data\ActiveDataProvider;
use common\models\behaviors\DateRangeSearchBehavior;

/**
 * @property integer $id
 * @property string $alias
 * @property integer $type
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property PageI18n[] $pageI18ns
 */
class PageSearch extends Page
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
            'status',
            'type',
            'created_at',
            'updated_at',
            'created_by',
            'updated_by',
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
        $query = Page::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if ($params !== null) {
            $this->load($params);
        }

        if (!$this->validate()) {
            return $dataProvider;
        }

        $this->fillDateRangeAttributes($query);

        $query->andFilterWhere(['type' => $this->type]);
        $query->andFilterWhere(['status' => $this->status]);
        return $dataProvider;
    }
}
