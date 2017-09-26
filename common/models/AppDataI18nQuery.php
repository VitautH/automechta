<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[AppDataI18n]].
 *
 * @see AppDataI18n
 */
class AppDataI18nQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return AppDataI18n[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return AppDataI18n|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}