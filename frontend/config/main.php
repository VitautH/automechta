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
            'allowedIPs' => ['93.85.147.180'] //
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
                'brand/' => 'brand/index',
                'brand/search' => 'brand/search',
                'brand/<productType:.+>/<maker:.+>' => 'brand/maker',
                'brand/<productType:.+>' => 'brand/category',
                'sitemap.xml' => 'sitemap/index',
            ],
        ],
        'menu' => [
            'class' => 'frontend\components\Menu'
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