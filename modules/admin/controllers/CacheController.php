<?php

/**
 * Created by PhpStorm.
 * User: resh
 * Date: 10.05.17
 * Time: 13:05
 */

namespace app\modules\admin\controllers;

use app\components\Helper;
use app\models\Category;
use app\models\ImportForm;
use app\models\Products;
use app\models\ProductsBackup;
use app\models\ProductsImages;
use app\models\ProductsSearch;
use Codeception\Module\Yii2;
use app\helpers\Inflector;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use dektrium\user\filters\AccessRule;
use yii\filters\AccessControl;
use yii\web\UploadedFile;

class CacheController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'ruleConfig' => [
                    'class' => AccessRule::class,
                ],
                'rules' => [
                    [
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return \Yii::$app->user->identity->role == 'admin';
                        }
                    ],
                    [
                        'allow' => false,
                    ]
                ],
            ],
        ];
    }

    public function actionClear()
    {
        \Yii::$app->cache->flush();
        \Yii::$app->session->setFlash('success', "Кэш очищен");
        if (\Yii::$app->request->referrer) {
            return $this->redirect(\Yii::$app->request->referrer);
        } else {
            return $this->goBack('/' . MODULE_ID . '/catalog');
        }
    }
}
