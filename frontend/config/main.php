<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

$config = [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'homeUrl' => '/',
    'modules' => [
        'api' => [
            'class' => 'frontend\modules\api\Module',
        ],
        'debug' => [ // панель на хостинге
            'class' => 'yii\debug\Module', //
            'allowedIPs' => [''] //
        ],
    ],

    'components' => [
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'vkontakte' => [
                    'class' => 'yii\authclient\clients\VKontakte',
                    'clientId' => '6182219',
                    'clientSecret' => 'oJe0CfAi8wrCO4oVGoeM',
                ],
                'facebook' => [
                    'class' => 'yii\authclient\clients\Facebook',
                    'clientId' => '1983448668607489',
                    'clientSecret' => 'ad7b1b9d786e7c82d9f5e1308054bed5',
                ],
                'google' => [
                    'class' => 'yii\authclient\clients\Google',
                    'clientId' => '389387349879-evojvno6met4o5kt7p8f7n3v55d7tbji.apps.googleusercontent.com',
                    'clientSecret' => 'yZ0TE9_ghTzJ8-jyWtoRJSx9',
                    'scope' => 'https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/userinfo.email',
                    'returnUrl' => 'https://www.automechta.by/site/auth?authclient=google',
                ],
                'yandex' => [
                    'class' => 'yii\authclient\clients\Yandex',
                    'clientId' => '3bc893230a8040e39f91be1924287cf3',
                    'clientSecret' => '7e7ee7382a814ef697bddcc4d1ea6bde',
                    'returnUrl' => 'https://www.automechta.by/site/auth?authclient=yandex',
                ],
            ],
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                    'logFile' => '@app/log.txt',
                    'logVars' => []

                ],
            ],
        ],

        'urlManager' => [
            'rules' => [
                [
                    'pattern' => 'client-script/requirejs',
                    'route' => 'client-script/requirejs',
                    'suffix' => '.js',
                ],
                '<alias:avto-v-kredit|oformlenie-schet-spravki|srochnyj-vykup|prijom-avto-na-komissiju|trade-In(Obmen)>' => 'page/show',
                'brand/<productType:.+>/<maker:.+>/<modelauto:.+>' => 'brand/modelauto',
                'brand/<productType:.+>/<maker:.+>' => 'brand/maker',
                'brand/<productType:.+>' => 'brand/category',
                'cars/company' => 'brand/categorycompany',
                '<productType:cars|moto>/<maker:.+>/<modelauto:.+>/<id:.+>' => 'catalog/newshow',
                '<productType:cars|moto>' => 'brand/newcategory',
                '<productType:cars|moto>/<maker:.+>/<modelauto:.+>' => 'brand/newmodelauto',
                '<productType:cars|moto>/<maker:.+>' => 'brand/newmaker',
                'search/<productType:cars|moto>' => 'brand/search',
                'sitemap.xml' => 'sitemap/index',
            ],
        ],
        'menu' => [
            'class' => 'frontend\components\Menu'
        ],
        'cache' => [
            'class' => 'common\components\Cache',
            'host' => '127.0.0.1',
            'port' => '6379'
        ],
        'view' => [
            'class' => 'frontend\components\View'
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'request' => [
            'baseUrl' => '',
        ],
        'assetManager' => [
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'sourcePath' => null,
                    'basePath' => '@webroot',
                    'baseUrl' => '@web',
                    'js' => [
                        'theme/js/jquery-1.11.3.min.js',
                    ]
                ],
            ]
        ],
    ],
    'params' => $params,
];

return $config;