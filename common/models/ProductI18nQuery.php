<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[ProductI18n]].
 *
 * @see ProductI18n
 */
class ProductI18nQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return ProductI18n[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ProductI18n|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}