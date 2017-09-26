<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Product]].
 *
 * @see Product
 */
class ProductQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        $this->andWhere('[[product.status]]=1');
        return $this;
    }

    public function notVerified()
    {
        $this->andWhere('[[product.status]]='.Product::STATUS_TO_BE_VERIFIED);
        return $this;
    }

    public function createdBy($userId)
    {
        $userId = intval($userId);
        $this->andWhere('[[product.created_by]]='.$userId);
        return $this;
    }

    public function highPriority()
    {
        $this->andWhere('[[priority]]=1');
        return $this;
    }

    public function lowPriority()
    {
        $this->andWhere('[[priority]]=0');
        return $this;
    }

    /**
     * @inheritdoc
     * @return Product[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Product|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}