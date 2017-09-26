<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[PageI18n]].
 *
 * @see PageI18n
 */
class PageI18nQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return PageI18n[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return PageI18n|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}