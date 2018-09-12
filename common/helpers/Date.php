<?php

namespace common\helpers;

use DateTime;
use Yii;

class Date
{
    public static function dateToUnix($date)
    {
        $date = new DateTime($date);
        $date->format('m-d-Y');

        return $date->getTimestamp();
    }
}