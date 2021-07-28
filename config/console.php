<?php

$params = require(__DIR__ . '/params.php');
$db = require(__DIR__ . '/db.php');

$config = [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'app\commands',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
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
                        $e->action->controller->layout = '@app/views/layouts/admin';
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
    ],
    'controllerMap' => [
        'migrate' => [
            'class' => 'yii\console\controllers\MigrateController',
            'migrationPath' => '@vendor/dektrium/yii2-user/migrations',
            'migrationNamespaces' => [
                'app\migrations', // Common migrations for the whole application
            ],
        ],
    ],
    /*
    'controllerMap' => [
        'fixture' => [ // Fixture generation command line.
            'class' => 'yii\faker\FixtureController',
        ],
    ],
    */
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
