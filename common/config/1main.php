<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'name' => 'AutoMechta.by',
    'language' => 'ru-RU',
    'sourceLanguage' => 'en-US',
    'bootstrap' => ['job'],
    'components' => [
        'user' => [
            'class' => 'common\components\User',
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
        ],
        'elasticsearch' => [
            'class' => 'yii\elasticsearch\Connection',
            'nodes' => [
                ['http_address' => '127.0.0.1:9200'],
                // configure more hosts if you have a cluster
            ],
        ],
        'productEvent' => [
            'class' => \common\models\ProductEvent::className(),
           'on updateProduct' => ['common\models\ProductEvent', 'updateProduct'],
        ],
        'uploads' => [
            'class' => 'common\components\Uploads'
        ],
        'i18n' => [
            'translations' => [
                'app' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                    'sourceLanguage' => 'en-US',
                ],
            ],
        ],
        'redis' => [
            'class' => 'yii\redis\Connection',
            'hostname' => 'localhost',
            'port' => 6379,
            'database' => 0,
        ],
        'session' => [

            'class' => 'yii\redis\Session',

        ],

        'cache' => [
            'class' => 'common\components\Cache',
            'host' => '127.0.0.1',
            'port' => '6379'
        ],
        'job' => [
            'class' => 'common\components\Job',
          'jobs'=>[
               [
                  'nameJob'=>'ParserTutby',
                  'classJob'=>\common\models\Parsernews::class,
                  'methodJob' => 'getTutbyNews',
                  'timerJob'=>'7200',
              ],
          ]
        ],
        'indexing' => [
            'class' => 'common\components\Indexing',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    'pattern' => 'client-script/requirejs',
                    'route' => 'client-script/requirejs',
                    'suffix' => '.js',
                ],
            ],
        ],
        'assetManager' => [
            'appendTimestamp' => true,
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'jsOptions' => ['position' => \yii\web\View::POS_HEAD],
                ]
            ],
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'defaultRoles' => ['Guest'],
        ],
    ],
];
