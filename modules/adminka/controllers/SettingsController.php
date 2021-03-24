<?php
/**
 * Created by PhpStorm.
 * User: resh
 * Date: 08.05.17
 * Time: 10:09
 */

namespace app\modules\adminka\controllers;

use yii\web\Controller;
use Yii;
use dektrium\user\models\Token;
use dektrium\user\filters\AccessRule;
use yii\filters\AccessControl;

class SettingsController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'ruleConfig' => [
                    'class' => AccessRule::className(),
                ],
                'rules' => [
                    [
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return \Yii::$app->user->identity->role == 'admin';
                        }
                    ],
                ],
            ],
        ];
    }


    public function actionIndex()
    {
        return $this->redirect('/adminka/settings/auth');
    }

    public function actions()
    {
        return [
            // 'index' => [
            //     'class' => 'pheme\settings\SettingsAction',
            //     'modelClass' => 'app\models\Settings',
            //     'scenario' => 'main',	// Change if you want to re-use the model for multiple setting form.
            //     'viewName' => 'index'	// The form we need to render
            // ],
            'auth' => [
                'class' => 'pheme\settings\SettingsAction',
                'modelClass' => 'app\models\Settings',
                'scenario' => 'auth',	// Change if you want to re-use the model for multiple setting form.
                'viewName' => 'auth'	// The form we need to render
            ],
            'emails' => [
                'class' => 'pheme\settings\SettingsAction',
                'modelClass' => 'app\models\Settings',
                'scenario' => 'emails',	// Change if you want to re-use the model for multiple setting form.
                'viewName' => 'emails'	// The form we need to render
            ],
            'mail' => [
                'class' => 'pheme\settings\SettingsAction',
                'modelClass' => 'app\models\Settings',
                'scenario' => 'mail',	// Change if you want to re-use the model for multiple setting form.
                'viewName' => 'mail'	// The form we need to render
            ],
            'notify' => [
                'class' => 'pheme\settings\SettingsAction',
                'modelClass' => 'app\models\Settings',
                'scenario' => 'notify',	// Change if you want to re-use the model for multiple setting form.
                'viewName' => 'notify'	// The form we need to render
            ],
            'hint' => [
                'class' => 'pheme\settings\SettingsAction',
                'modelClass' => 'app\models\Settings',
                'scenario' => 'hint',	// Change if you want to re-use the model for multiple setting form.
                'viewName' => 'hint'	// The form we need to render
            ],
        ];
    }


    
    public function beforeAction($action)
    {
        Yii::$app->i18n->translations['extensions/yii2-settings/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en',
            'basePath' => '@vendor/pheme/yii2-settings/messages',
            'fileMap' => [
                'extensions/yii2-settings/settings' => 'settings.php',
            ],
        ];
        return parent::beforeAction($action);
    }



}