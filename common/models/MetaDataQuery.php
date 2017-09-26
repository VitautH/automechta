<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[MetaData]].
 *
 * @see MetaData
 */
class MetaDataQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return MetaData[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return MetaData|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}