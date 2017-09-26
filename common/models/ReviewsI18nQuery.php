<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[ReviewsI18n]].
 *
 * @see ReviewsI18n
 */
class ReviewsI18nQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return ReviewsI18n[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ReviewsI18n|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}