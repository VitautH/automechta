<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace common\models\behaviors;

use yii\base\Behavior;

/**
 * @author Aleh Hutnikau <goodnickoff@gmail.com>
 */
class DateRangeSearchBehavior extends Behavior
{
    /**
     * @var array
     */
    public $dateRangeAttributes = ['created_at', 'updated_at'];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
    }

    /**
     * @param \yii\db\ActiveQuery $query
     */
    public function fillDateRangeAttributes($query)
    {
        $owner = $this->owner;
        foreach ($this->dateRangeAttributes as $dateRangeAttribute) {
            $range = explode('/', $owner->$dateRangeAttribute);

            if (count($range) == 2 && $this->checkIsAValidDate($range[0]) && $this->checkIsAValidDate($range[1])) {
                $from = new \DateTime(trim($range[0]));
                $to = new \DateTime(trim($range[1]));

                if (!$this->dateHasTime($range[1])) {
                    $to->add(new \DateInterval('P1D'));
                }

                $query->andWhere("$dateRangeAttribute>=:from", [':from'=>$from->getTimestamp()]);
                $query->andWhere("$dateRangeAttribute<=:to", [':to'=>$to->getTimestamp()]);
            } elseif (count($range) == 1 && $this->checkIsAValidDate($range[0])) {
                $from = new \DateTime(trim($range[0]));
                $to = new \DateTime(trim($range[0]));

                if (!$this->dateHasTime($range[0])) {
                    $to->add(new \DateInterval('P1D'));
                }

                $query->andWhere("$dateRangeAttribute>=:from", [':from'=>$from->getTimestamp()]);
                $query->andWhere("$dateRangeAttribute<=:to", [':to'=>$to->getTimestamp()]);
            } else {
                $query->andFilterWhere(['created_at' => $owner->$dateRangeAttribute]);
            }
        }
    }

    /**
     * Check whether date string is valid date value.
     * @param string $date
     * @return bool
     */
    private function checkIsAValidDate($date){
        return (bool) strtotime($date);
    }

    /**
     * Check whether date string has time.
     * @param string $date
     * @return bool
     */
    private function dateHasTime($date)
    {
        $date = date_parse($date);
        return $date['hour'] !== false;
    }
}
