<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language' => 'ru',
    'timeZone' => 'Europe/Moscow',
    'components' => [
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'tIeB_MY1BTFLTTt97kj8oUDvJZcncdjK',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => '/signin'
        ],
        'mailer' => function () {
            return \Yii::createObject([
                'class' => 'yii\swiftmailer\Mailer',
                'transport' => [
                    'class' => 'Swift_SmtpTransport',
                    'host' => \Yii::$app->settings->get('Settings.smtpHost'),
                    'username' => \Yii::$app->settings->get('Settings.smtpEmail'),
                    'password' => \Yii::$app->settings->get('Settings.smtpPassword'),
                    'port' => \Yii::$app->settings->get('Settings.smtpPort'),
                    'encryption' => \Yii::$app->settings->get('Settings.smtpEncryption'),
                    'streamOptions' => [
                        'ssl' => [
                            'verify_peer' => !!Yii::$app->settings->get('Settings.smtpStreamOptionsSslVerifyPeer'),
                            'allow_self_signed' => !!Yii::$app->settings->get('Settings.smtpStreamOptionsSslAllowSelfSigned')
                        ],
                    ],
                ],
                'useFileTransport' => false
                // send all mails to a file by default. You have to set
                // 'useFileTransport' to false and configure a transport
                // for the mailer to send real emails.
            ]);


            // public $smtpHost;
            // public $smtpEmail;
            // public $smtpPassword;
            // public $smtpPort;
            // public $smtpEncryption;
            // public $smtpStreamOptionsSslVerifyPeer;
            // public $smtpStreamOptionsSslAllowSelfSigned;
        },
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),

        'urlManager' => [
            'class' => 'app\components\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'sitemap.xml' => 'site/sitemap',
            ],
        ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@dektrium/user/views' => '@app/views/user'
                ],
            ],
        ],
        'settings' => [
            'class' => 'pheme\settings\components\Settings',
            'modelClass' => '\app\models\Settings2'
        ],

        'i18n' => [
            'translations' => [
                'file-input*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => dirname(__FILE__) . '/../vendor/2amigos/yii2-file-input-widget/src/messages/',
                ],
            ],
        ],
        'assetManager' => [
            'class' => 'yii\web\AssetManager',
            'forceCopy' => true,
            'bundles' => [
                'kartik\grid\GridGroupAsset' => [
                    'js' => [
                        '/js/kv-grid-group.js'
                    ]
                ]
            ]
        ],

        'sms' => [
            'class'    => 'ladamalina\smsc\Smsc',
            'login'     => 'LegkiyVeter',  // login
            'password'   => 'phyqkWg4iAY4Wns', // plain password or lowercase password MD5-hash
            'post' => true, // use http POST method
            'https' => true,    // use secure HTTPS connection
            'charset' => 'utf-8',   // charset: windows-1251, koi8-r or utf-8 (default)
            'debug' => false,    // debug mode
        ],
        'reCaptcha' => [
            'name' => 'reCaptcha',
            'class' => 'himiklab\yii2\recaptcha\ReCaptcha',
            'siteKey' => '6Lf_rYwUAAAAAGAUXG-oRX4uOQpSoZGYRTSviiP8',
            'secret' => '6Lf_rYwUAAAAAMxaG48CBE00MFBdUw3xApmWtuTV',
        ],

        'authClientCollection' => [
            'class'   => \yii\authclient\Collection::class,
            'clients' => [
                'vkontakte' => [
                    'class'        => 'dektrium\user\clients\VKontakte',
                    'clientId'     => 6852063,
                    'clientSecret' => 'bECDFSuJ5P8GTXJNuiV4',
                ]
            ],
        ],

        'telegram' => [
            'class' => 'aki\telegram\Telegram',
            'botToken' => '675807352:AAGVZH2o4q_3SORnEQrzi8-PH4pFmcGDLLY',
        ],
        'session' => [
            'class' => 'yii\web\DbSession',
            'writeCallback' => function () {
                return ['user_id' => \Yii::$app->user->id];
            },
        ],

    ],
    'params' => $params,
    'modules' => [
        'user' => [
            'class' => 'dektrium\user\Module',
            'enableGeneratingPassword' => true,
            'controllerMap' => [
                'tkbpfdtnf' => [
                    'class' => 'app\modules\admin\controllers\UserController',
                    'on ' . \dektrium\user\controllers\AdminController::EVENT_BEFORE_ACTION => function ($e) {
                        $e->action->controller->layout = '@app/views/layouts/admin';
                    }
                ],
                'manager12' => [
                    'class' => 'app\modules\manager\controllers\UserController',
                    'on ' . \dektrium\user\controllers\AdminController::EVENT_BEFORE_ACTION => function ($e) {
                        $e->action->controller->layout = '@app/views/layouts/manager';
                    }
                ],
                'registration' => [
                    'class' => \dektrium\user\controllers\RegistrationController::class,
                    'on ' . \dektrium\user\controllers\RegistrationController::EVENT_AFTER_CONFIRM => function ($e) {
                        Yii::$app->user->identity->mailer->sendSuccessMessage(Yii::$app->user->identity);
                        if (!Yii::$app->user->identity->getIsActive()) {
                            Yii::$app->session->setFlash('login', Yii::$app->settings->get('Settings.notify_unactive'));
                        }
                    }
                ]
            ],
            'modelMap' => [
                'Profile' => 'app\models\Profile',
                'User' => 'app\models\User',
                'RegistrationForm' => 'app\models\RegistrationForm',
                'LoginForm' => 'app\models\LoginForm'
            ],
            'urlRules' => [],
            'mailer' => [
                'class' => 'yii\swiftmailer\Mailer'
            ],
        ],
        'tkbpfdtnf' => [
            'class' => 'app\modules\admin\Module'
        ],
        'manager12' => [
            'class' => 'app\modules\manager\Module'
        ],
        'gridview' => [
            'class' => '\kartik\grid\Module'
        ]
    ],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
       'class' => 'yii\debug\Module',
    // uncomment the following to add your IP if you are not connecting from localhost.
    // 'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
