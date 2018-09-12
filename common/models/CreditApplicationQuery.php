<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[CreditApplication]].
 *
 * @see CreditApplication
 */
class CreditApplicationQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }

    public function arriveTomorrow()
    {
        $tomorrow = CreditApplication::dateToUnix(date("Y-m-d", strtotime('tomorrow')));
        $this->andWhere(['date_arrive'=>$tomorrow]);

        return $this;
    }

    /**
     * @inheritdoc
     * @return CreditApplication[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return CreditApplication|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}