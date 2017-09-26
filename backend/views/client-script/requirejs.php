<?php
if (!isset(Yii::$aliases['@webroot'])) {
    Yii::setAlias('@webroot', '@backend/web');
}
if (!isset(Yii::$aliases['@web'])) {
    Yii::setAlias('@web', '');
}
$mdlPath = '..' . Yii::$app->assetManager->getPublishedUrl('@npm/material-design-lite');
$commonWebPath = '..' . Yii::$app->assetManager->getPublishedUrl('@common/web');
$requireCssPath = '..' . Yii::$app->assetManager->getPublishedUrl('@bower/require-css');
$jqueryUiPath = '..' . Yii::$app->assetManager->getPublishedUrl('@common/web/js/libs/jquery-ui-1.11.4.custom');
$daterangepickerPath = '..' . Yii::$app->assetManager->getPublishedUrl('@common/web/js/libs/daterangepicker');
$momentPath = '..' . Yii::$app->assetManager->getPublishedUrl('@bower/moment');
$globalizePath = '..' . Yii::$app->assetManager->getPublishedUrl('@bower/globalize');
$dropzonePath = '..' . Yii::$app->assetManager->getPublishedUrl('@bower/dropzone');
$select2Path = '..' . Yii::$app->assetManager->getPublishedUrl('@bower/select2');
$jsTree = '..' . Yii::$app->assetManager->getPublishedUrl('@bower/jstree/dist');

$version = YII_DEBUG ? microtime(true) : Yii::$app->params['version'];
?>
require.config({
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
        'modal' : '<?= $commonWebPath ?>/js/helpers/modal',
        'gridview' : '<?= $commonWebPath ?>/js/helpers/gridview',
        'list' : '<?= $commonWebPath ?>/js/helpers/list',
        'tree' : '<?= $commonWebPath ?>/js/helpers/tree',
        'preloader' : '<?= $commonWebPath ?>/js/helpers/preloader',
        'i18nForm' : '<?= $commonWebPath ?>/js/helpers/i18nForm',
        'i18n' : '<?= $commonWebPath ?>/js/helpers/i18n',
        'context' : '<?= $commonWebPath ?>/js/helpers/context',
        'polyfill' : '<?= $commonWebPath ?>/js/helpers/polyfill',
        'tinymceHelper' : '<?= $commonWebPath ?>/js/helpers/tinymceHelper',
        'uploader' : '<?= $commonWebPath ?>/js/helpers/uploader',
        'helpers' : '<?= $commonWebPath ?>/js/helpers/helpers',

        /* Modules */
        'application' : 'application',
        'mdl' : '<?= $mdlPath ?>/material',
        'qtip' : '<?= $commonWebPath ?>/js/libs/qtip/jquery.qtip.min',
        'tinymce' : '<?= $commonWebPath ?>/js/libs/tinymce/tinymce.min',
        'jquery_ui' : '<?= $jqueryUiPath ?>/jquery-ui',
        'daterangepicker' : '<?= $daterangepickerPath ?>/jquery.comiseo.daterangepicker',
        'moment' : '<?= $momentPath ?>/moment',
        'jstree' : '<?= $jsTree ?>/jstree',
        'globalize': '<?= $globalizePath ?>/dist/globalize/message',
        'dropzone': '<?= $dropzonePath ?>/dist/dropzone-amd-module',
        'select2' : '<?= $select2Path ?>/dist/js/select2.full',

        /* Controllers */
        'controllers/users/index' : 'controllers/users/index',
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
        'jstree' : {
            'deps': ['css!<?= $jsTree ?>/themes/default/style']
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
        'jquery_ui' : {
            'deps': [
                'css!<?= $jqueryUiPath ?>/jquery-ui.min.css'
            ]
        }
    },
    deps : ['application']
});