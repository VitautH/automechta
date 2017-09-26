<?php

namespace common\models;

use Yii;
use yii\data\ActiveDataProvider;
use common\models\behaviors\DateRangeSearchBehavior;

/**
 * @property integer $id
 * @property integer $lft
 * @property integer $rgt
 * @property integer $depth
 * @property string $link
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property SliderI18n[] $sliderI18ns
 */
class SliderSearch extends Slider
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
        $query = Slider::find();

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
