<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[SpecificationI18n]].
 *
 * @see SpecificationI18n
 */
class SpecificationI18nQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SpecificationI18n[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SpecificationI18n|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}