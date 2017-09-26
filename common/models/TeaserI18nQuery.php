<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[TeaserI18n]].
 *
 * @see TeaserI18n
 */
class TeaserI18nQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return TeaserI18n[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return TeaserI18n|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}