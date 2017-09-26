<?php
if (!isset(Yii::$aliases['@webroot'])) {
    Yii::setAlias('@webroot', '@frontend/web');
};
if (!isset(Yii::$aliases['@web'])) {
    Yii::setAlias('@web', '');
};
$commonWebPath = '..' . Yii::$app->assetManager->getPublishedUrl('@common/web');
$requireCssPath = '..' . Yii::$app->assetManager->getPublishedUrl('@bower/require-css');
$jqueryUiPath = '..' . Yii::$app->assetManager->getPublishedUrl('@common/web/js/libs/jquery-ui-1.11.4.custom');
$daterangepickerPath = '..' . Yii::$app->assetManager->getPublishedUrl('@common/web/js/libs/daterangepicker');
$momentPath = '..' . Yii::$app->assetManager->getPublishedUrl('@bower/moment');
$globalizePath = '..' . Yii::$app->assetManager->getPublishedUrl('@bower/globalize');
$dropzonePath = '..' . Yii::$app->assetManager->getPublishedUrl('@bower/dropzone');
$select2Path = '..' . Yii::$app->assetManager->getPublishedUrl('@bower/select2');
$UrijsPath = '..' . Yii::$app->assetManager->getPublishedUrl('@bower/urijs');

$version = YII_DEBUG ? microtime(true) : Yii::$app->params['version'];
?>
require.config({
    waitSeconds : 200,
    config: {
        'context' : {
            'locale' : '<?= Yii::$app->language ?>'
        }
    },
    // Add this map config in addition to any baseUrl or
    // paths config you may already have in the project.
    map: {
        // '*' means all modules will get 'jquery-private'
        // for their 'jquery' dependency.
        '*': {
            'jquery': 'components/jquery-private',
            'css': '<?= $requireCssPath ?>/css'
        },

        // 'jquery-private' wants the real jQuery module
        // though. If this line was not here, there would
        // be an unresolvable cyclic dependency.
        'jquery-private': { 'jquery': 'jquery' },
    },
    urlArgs : 'v=<?= $version ?>',
    baseUrl : '<?= YII_ENV_PROD ? '/build' : '/js' ?>',
    paths : {
        /* Helpers */
        'gridview' : '<?= $commonWebPath ?>/js/helpers/gridview',
        'modal' : '<?= $commonWebPath ?>/js/helpers/modal',
        'list' : '<?= $commonWebPath ?>/js/helpers/list',
        'context' : '<?= $commonWebPath ?>/js/helpers/context',
        'polyfill' : '<?= $commonWebPath ?>/js/helpers/polyfill',
        'uploader' : '<?= $commonWebPath ?>/js/helpers/uploader',
        'helpers' : '<?= $commonWebPath ?>/js/helpers/helpers',
        'i18n' : '<?= $commonWebPath ?>/js/helpers/i18n',
        'preloader' : 'helpers/preloader',

        /* Modules */
        'application' : 'application',
        'qtip' : '<?= $commonWebPath ?>/js/libs/qtip/jquery.qtip.min',
        'jquery_ui' : '<?= $jqueryUiPath ?>/jquery-ui',
        'daterangepicker' : '<?= $daterangepickerPath ?>/jquery.comiseo.daterangepicker',
        'moment' : '<?= $momentPath ?>/moment',
        'globalize': '<?= $globalizePath ?>/dist/globalize/message',
        'dropzone': '<?= $dropzonePath ?>/dist/dropzone-amd-module',
        'select2' : '<?= $select2Path ?>/dist/js/select2.full',
        'urijs': '<?= $UrijsPath ?>/src',
        'theme' : '../theme',
        'themeAmd' : 'components/themeAmd',
        'maskedinput' : '<?= $commonWebPath ?>/js/libs/jquery.maskedinput/jquery.maskedinput',
        'accrue' : '<?= $commonWebPath ?>/js/libs/accrue/jquery.accrue',
        'accounting' : '<?= $commonWebPath ?>/js/libs/accounting.min',

        /* Controllers */
        'controllers/site/index' : 'controllers/site/index'
    },
    shim: {
        'select2' : {
            'deps': [
                'css!<?= $select2Path ?>/dist/css/select2'
            ]
        },
        'qtip' : {
            'deps': [
                'css!<?= $commonWebPath ?>/js/libs/qtip/jquery.qtip.min'
            ]
        },
        'application' : {
            'deps' : [
                'jquery_ui'
            ]
        },
        'themeAmd' : {
            'deps' : [
                'jquery_ui',
                'theme/assets/bxslider/jquery.bxslider'
            ]
        },
        'daterangepicker' : {
            'deps': [
                'moment',
                'jquery_ui',
                'css!<?= $daterangepickerPath ?>/jquery.comiseo.daterangepicker'
            ],
            init : function (m, jqueryUI) {
                window.moment = m;
            }
        },

    },
    deps : ['application']
});