<?php

namespace common\models;

use creocoder\nestedsets\NestedSetsQueryBehavior;

/**
 * This is the ActiveQuery class for [[Teaser]].
 *
 * @see Teaser
 */
class TeaserQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        $this->andWhere('[[status]]='.Teaser::STATUS_PUBLISHED);
        $this->andWhere('[[depth]]>0');
        return $this;
    }

    /**
     * @inheritdoc
     * @return Teaser[]|array
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
     * @return Teaser|array|null
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