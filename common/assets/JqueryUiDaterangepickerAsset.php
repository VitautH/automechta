<?php

namespace common\assets;

use yii\web\AssetBundle;

class JqueryUiDaterangepickerAsset extends AssetBundle
{
    public $sourcePath  = '@common/web/js/libs/daterangepicker';

    public $depends = [
        'common\assets\MomentAsset',
    ];
}
