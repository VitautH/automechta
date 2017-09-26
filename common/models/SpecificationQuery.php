<?php

namespace common\models;

use creocoder\nestedsets\NestedSetsQueryBehavior;

/**
 * This is the ActiveQuery class for [[Specification]].
 *
 * @see Specification
 */
class SpecificationQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Specification[]|array
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
     * @return Specification|array|null
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