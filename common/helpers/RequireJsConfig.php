<?php

namespace common\helpers;

use Yii;

/**
 * @author Aleh Hutnikau <goodnickoff@gmail.com>
 */
class RequireJsConfig
{
    /**
     * Render dynamic requireJs config
     * @param string $path
     * @return string config
     */
    public static function getConfig($path = '@app/views/client-script/requirejs.php')
    {
        /** @var \yii\web\View $view */
        $view = Yii::$app->getView();
        $result = $view->render($path);
        return $result;
    }
}