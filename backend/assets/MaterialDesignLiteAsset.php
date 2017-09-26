<?php

namespace backend\assets;

use yii\web\AssetBundle;
use Yii;

/**
 * Class MaterializeAsset
 * @package backend\assets
 * @author Aleh Hutnikau <goodnickoff@gmail.com>
 */
class MaterialDesignLiteAsset extends AssetBundle
{
    public $sourcePath = '@npm/material-design-lite';

    public $css = [
        'https://fonts.googleapis.com/icon?family=Material+Icons',
        'https://fonts.googleapis.com/css?family=Roboto:400,700italic,700,500italic,500,400italic,300italic,300,100italic,100&subset=latin,cyrillic',
    ];

    public $jsOptions = [
        'position' => \yii\web\View::POS_HEAD,
    ];

    public $js = [
        'material.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}