require.config({
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
        'moment' : '../assets/e13874f1/js/helpers/moment',
        'modal' : '../assets/e13874f1/js/helpers/modal',
        'gridview' : '../assets/e13874f1/js/helpers/gridview',
        'list' : '../assets/e13874f1/js/helpers/list',
        'tree' : '../assets/e13874f1/js/helpers/tree',
        'preloader' : '../assets/e13874f1/js/helpers/preloader',
        'i18nForm' : '../assets/e13874f1/js/helpers/i18nForm',
        'i18n' : '../assets/e13874f1/js/helpers/i18n',
        'context' : '../assets/e13874f1/js/helpers/context',
        'polyfill' : '../assets/e13874f1/js/helpers/polyfill',
        'tinymceHelper' : '../assets/e13874f1/js/helpers/tinymceHelper',
        'uploader' : '../assets/e13874f1/js/helpers/uploader',
        'helpers' : '../assets/e13874f1/js/helpers/helpers',
 'uploader' : '../assets/e13874f1/js/helpers/uploader',
    'preloader' : 'helpers/preloader',

        /* Modules */
        'application' : 'application',
        'mdl' : '../assets/bd9c07ec/material',
        'qtip' : '../assets/e13874f1/js/libs/qtip/jquery.qtip.min',
        'tinymce' : '../assets/e13874f1/js/libs/tinymce/tinymce.min',
        'jquery_ui' : '../assets/1e6a7a0b/jquery-ui',
        'daterangepicker' : '../assets/16660def/jquery.comiseo.daterangepicker',
        'moment' : '../assets/b48921d1/moment',
        'jstree' : '../assets/ce0e97a9/jstree',
        'globalize': '../assets/fbab3cf2/dist/globalize/message',
        'dropzone': '../assets/a9762452/dist/dropzone-amd-module',
        'select2' : '../assets/6858b90e/dist/js/select2.full',
 'maskedinput' : '../assets/e13874f1/js/libs/jquery.maskedinput/jquery.maskedinput',

        /* Controllers */
        'controllers/users/index' : 'controllers/users/index',
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
        'jstree' : {
            'deps': ['css!../assets/ce0e97a9/themes/default/style']
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
        'jquery_ui' : {
            'deps': [
                'css!../assets/1e6a7a0b/jquery-ui.min.css'
            ]
        }
    },
    deps : ['application']
});