<?php

namespace common\models;

use creocoder\nestedsets\NestedSetsQueryBehavior;

/**
 * This is the ActiveQuery class for [[Slider]].
 *
 * @see Slider
 */
class SliderQuery extends \yii\db\ActiveQuery
{
    public function published()
    {
        $this->andWhere('status=' . SLIDER::STATUS_PUBLISHED . ' AND depth>0');
        return $this;
    }

    /**
     * @inheritdoc
     * @return Slider[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * get root node
     * @return Menu|array|null
     */
    public function root()
    {
        $this->andWhere('depth=0');
        return $this;
    }

    /**
     * @inheritdoc
     * @return Slider|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }


    /**
     * @return array
     */
    public function behaviors() {
        return [
            NestedSetsQueryBehavior::className(),
        ];
    }
}