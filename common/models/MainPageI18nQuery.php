<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[MainPageI18n]].
 *
 * @see MainPageI18n
 */
class MainPageI18nQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return MainPageI18n[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return MainPageI18n|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}