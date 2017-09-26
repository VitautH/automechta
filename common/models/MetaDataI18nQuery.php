<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[MetaDataI18n]].
 *
 * @see MetaDataI18n
 */
class MetaDataI18nQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return MetaDataI18n[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return MetaDataI18n|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}