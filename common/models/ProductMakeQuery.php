<?php

namespace common\models;

use creocoder\nestedsets\NestedSetsQueryBehavior;

/**
 * This is the ActiveQuery class for [[ProductMake]].
 *
 * @see ProductMake
 */
class ProductMakeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    public function top($priority = null)
    {
        if ($priority === null) {
            $this->select('*, (SELECT COUNT(id) FROM product WHERE product.make = product_make.id) AS num');
        } else {
            $this->select('*, (SELECT COUNT(id) FROM product WHERE product.make = product_make.id AND product.priority='.$priority.') AS num');
        }
        $this->orderBy('num DESC');
        return $this;
    }

    /**
     * @inheritdoc
     * @return ProductMake[]|array
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
     * @return ProductMake|array|null
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