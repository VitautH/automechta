<?php
/**
 * Created by PhpStorm.
 * User: Vitaut
 * Date: 01.03.2018
 * Time: 15:02
 */

namespace common\helpers;

use yii\helpers\Html;
use Yii;

class User extends \common\models\User
{
    public static function getAvatar($id, $width = null, $height = null, $round = null, $class = null)
    {
        $src = Yii::$app->uploads->getUploadsData('user', $id)[0]["path"];
        if (!empty($src)) {
            if ($width === null) {
                $width = '100%';
            }
            if ($height === null) {
                $height = '100%';
            }
            if ($round === null) {
                $round = 0;
            }


            $options = ['class' => $class, 'style' => ['width' => $width, 'height' => $height, 'border-radius' => $round]];

            return Html::img($src, $options);
        } else {
            return null;
        }
    }

    public static function getAvatarUrl($id)
    {
        $src = Yii::$app->uploads->getUploadsData('user', $id)[0]["path"];
        if (!empty($src)) {
            return $src;
        } else {
            return null;
        }
    }
}