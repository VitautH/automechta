<?php

namespace common\models;

use Yii;
use yii\data\ActiveDataProvider;
use common\models\behaviors\DateRangeSearchBehavior;

/**
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property ProductTypeI18n[] $productTypeI18ns
 */
class ProductTypeSearch extends ProductType
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
        $scenarios[self::SCENARIO_SEARCH] = [];

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
        $query = ProductType::find();

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

        return $dataProvider;
    }
}
