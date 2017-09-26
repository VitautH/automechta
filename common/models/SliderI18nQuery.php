<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[SliderI18n]].
 *
 * @see SliderI18n
 */
class SliderI18nQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SliderI18n[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SliderI18n|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}