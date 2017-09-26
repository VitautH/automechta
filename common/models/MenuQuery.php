<?php

namespace common\models;

use creocoder\nestedsets\NestedSetsQueryBehavior;

/**
 * This is the ActiveQuery class for [[Menu]].
 *
 * @see Menu
 */
class MenuQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Menu[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Menu|array|null
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