require.config({
    waitSeconds : 200,
    config: {
        'context' : {
            'locale' : 'ru-RU'
        }
    },
    // Add this map config in addition to any baseUrl or
    // paths config you may already have in the project.
    map: {
        // '*' means all modules will get 'jquery-private'
        // for their 'jquery' dependency.
        '*': {
            'jquery': 'components/jquery-private',
            'css': '../assets/4c1f8857/css'
        },

        // 'jquery-private' wants the real jQuery module
        // though. If this line was not here, there would
        // be an unresolvable cyclic dependency.
        'jquery-private': { 'jquery': 'jquery' },
    },
    urlArgs : 'v=0.992',
    baseUrl : '/build',
    paths : {
        /* Helpers */
        'gridview' : '../assets/e13874f1/js/helpers/gridview',
        'modal' : '../assets/e13874f1/js/helpers/modal',
        'list' : '../assets/e13874f1/js/helpers/list',
        'context' : '../assets/e13874f1/js/helpers/context',
        'polyfill' : '../assets/e13874f1/js/helpers/polyfill',
        'uploader' : '../assets/e13874f1/js/helpers/uploader',
        'helpers' : '../assets/e13874f1/js/helpers/helpers',
        'i18n' : '../assets/e13874f1/js/helpers/i18n',
        'preloader' : 'helpers/preloader',

        /* Modules */
        'application' : 'application',
        'qtip' : '../assets/e13874f1/js/libs/qtip/jquery.qtip.min',
        'jquery_ui' : '../assets/1e6a7a0b/jquery-ui',
        'daterangepicker' : '../assets/16660def/jquery.comiseo.daterangepicker',
        'moment' : '../assets/b48921d1/moment',
        'globalize': '../assets/fbab3cf2/dist/globalize/message',
        'dropzone': '../assets/a9762452/dist/dropzone-amd-module',
        'select2' : '../assets/6858b90e/dist/js/select2.full',
        'urijs': '../assets/c86a4839/src',
        'theme' : '../theme',
        'themeAmd' : 'components/themeAmd',
        'maskedinput' : '../assets/e13874f1/js/libs/jquery.maskedinput/jquery.maskedinput',
        'accrue' : '../assets/e13874f1/js/libs/accrue/jquery.accrue',
        'accounting' : '../assets/e13874f1/js/libs/accounting.min',

        /* Controllers */
        'controllers/site/index' : 'controllers/site/index'
    },
    shim: {
        'select2' : {
            'deps': [
                'css!../assets/6858b90e/dist/css/select2'
            ]
        },
        'qtip' : {
            'deps': [
                'css!../assets/e13874f1/js/libs/qtip/jquery.qtip.min'
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
                'css!../assets/16660def/jquery.comiseo.daterangepicker'
            ],
            init : function (m, jqueryUI) {
                window.moment = m;
            }
        },

    },
    deps : ['application']
});