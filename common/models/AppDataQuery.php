<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[AppData]].
 *
 * @see AppData
 */
class AppDataQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return AppData[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return AppData|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}