<?php

namespace common\models;

use creocoder\nestedsets\NestedSetsQueryBehavior;

/**
 * This is the ActiveQuery class for [[ProductType]].
 *
 * @see ProductType
 */
class ProductTypeQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        $this->andWhere('[[depth]]>0');
        return $this;
    }

    /**
     * @inheritdoc
     * @return ProductType[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ProductType|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
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
     * @return array
     */
    public function behaviors() {
        return [
            NestedSetsQueryBehavior::className(),
        ];
    }
}