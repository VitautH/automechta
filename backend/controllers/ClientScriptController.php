<?php

namespace backend\controllers;

use yii\web\Response;
use common\helpers\RequireJsConfig;
use Yii;

/**
 * Class ClientScriptController
 * @package backend\controllers
 * @author Aleh Hutnikau <goodnickoff@gmail.com>
 */
class ClientScriptController extends \yii\web\Controller
{
    public function actionRequirejs()
    {
        Yii::$app->response->format = Response::FORMAT_RAW;
        Yii::$app->response->getHeaders()->add('Content-Type', 'application/javascript');
        $config = RequireJsConfig::getConfig();
        if (YII_ENV_DEV) {
            file_put_contents(Yii::getAlias('@webroot/js/config.js'), $config);
        }
        return $config;
    }
}