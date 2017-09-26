<?php

namespace common\models;

use Yii;
use yii\data\ActiveDataProvider;
use common\models\behaviors\DateRangeSearchBehavior;

/**
 * @property integer $id
 * @property integer $status
 * @property integer $type
 * @property integer $make
 * @property integer $model
 * @property integer $price
 * @property integer $views
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property ProductType $type0
 * @property ProductI18n[] $productI18ns
 */
class ProductSearch extends Product
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
            'make',
            'model',
            'price',
            'year',
            'views',
            'priority',
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
        $query = Product::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if ($params !== null) {
            $this->load($params);
        }

        $query->andFilterWhere(['created_by' => $this->created_by]);
        $query->andFilterWhere(['priority' => $this->priority]);
        $query->andFilterWhere(['status' => $this->status]);
        $query->andFilterWhere(['id' => $this->id]);
        $query->andFilterWhere(['year' => $this->year]);
        $query->andFilterWhere(['like', 'model', $this->model]);
        if ($this->make != 0) {
            $query->andFilterWhere(['make' => $this->make]);
        }

        $this->fillDateRangeAttributes($query);

        return $dataProvider;
    }
}
