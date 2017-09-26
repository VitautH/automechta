<?php

namespace common\assets;

use yii\web\AssetBundle;

class CommonAsset extends AssetBundle
{
    public $sourcePath  = '@common/web';

    public $publishOptions = [
        'forceCopy' => YII_DEBUG,
    ];
}
