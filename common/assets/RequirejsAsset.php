<?php

namespace common\assets;

use yii\web\AssetBundle;

class RequirejsAsset extends AssetBundle
{
    public $sourcePath  = '@bower/r.js';
    public $baseUrl = '@web';

    public $js;

    public $jsOptions = [
        'position' => \yii\web\View::POS_HEAD,
    ];

    public $depends = [
        'common\assets\RequirejsCssAsset',
    ];

    public function __construct(array $config = [])
    {
        $this->js = [
            'require.js',
            YII_ENV_PROD ? '/build/config.js' : '/client-script/requirejs.js',
        ];
        parent::__construct($config);
    }
}
