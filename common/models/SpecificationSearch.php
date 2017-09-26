<?php

namespace common\models;

use Yii;
use yii\data\ActiveDataProvider;
use common\models\behaviors\DateRangeSearchBehavior;

/**
 * @property integer $id
 * @property integer $type
 * @property integer $direction
 * @property integer $required
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $lft
 * @property integer $rgt
 * @property integer $depth
 *
 * @property ProductTypeSpecifications[] $productTypeSpecifications
 * @property SpecificationI18n[] $specificationI18ns
 */
class SpecificationSearch extends Specification
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
        $scenarios[self::SCENARIO_SEARCH] = ['type', 'direction', 'required', 'created_at', 'updated_at', 'created_by', 'updated_by', 'lft', 'rgt', 'depth'];

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
        $query = Specification::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if ($params !== null) {
            $this->load($params);
        }

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['type' => $this->type]);

        $this->fillDateRangeAttributes($query);

        return $dataProvider;
    }
}
