<?php

namespace common\assets;

use yii\web\AssetBundle;

class JqueryUiAsset extends AssetBundle
{
    public $sourcePath  = '@common/web/js/libs/jquery-ui-1.11.4.custom';

    public $depends = [
        'common\assets\JqueryUiDaterangepickerAsset',
    ];
}
