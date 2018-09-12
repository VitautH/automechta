<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css;

    public $js = [
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'common\assets\RequirejsAsset',
        'common\assets\CommonAsset',
        'common\assets\JqueryUiAsset',
        'common\assets\UrijsAsset',
        'common\assets\DropzoneAsset',
    ];

    public function init()
    {
        parent::init();
        $this->css = [
            '/css/new-bootstrap.css?=' . \Yii::$app->params['version'],
            '/css/new-style.css?=' . \Yii::$app->params['version'],
            '/theme/css/font-awesome.min.css?=' . \Yii::$app->params['version'],
        ];
    }
}
