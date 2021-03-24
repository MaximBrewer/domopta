<?php
/**
 * Created by PhpStorm.
 * User: resh
 * Date: 16.05.17
 * Time: 10:33
 */

namespace app\modules\adminka\controllers;

use app\models\Order;
use app\models\OrderSearch;
use yii\web\Controller;
use dektrium\user\filters\AccessRule;
use yii\filters\AccessControl;
class OrdersController extends Controller
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
                    [
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return \Yii::$app->user->identity->role == 'manager';
                        }
                    ],
                    [
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return \Yii::$app->user->identity->role == 'contentmanager';
                        }
                    ],
                ],
            ],
        ];
    }

    public function actionIndex(){
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        return $this->render('index', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider]);
    }

    public function actionDelete(){
        $ids = \Yii::$app->request->post('selection');
        $models = Order::findAll(['id' => $ids]);
        foreach ($models as $model){
            $model->delete();
        }
        return $this->redirect(['index']);
    }

    public function actionUpdate($id){
        $order = Order::findOne($id);
        if(!$order){
            throw new NotFoundHttpException('Страница не найдена');
        }
        return $this->render('update', ['order' => $order]);
    }

    public function actionRecount($id){
        $order = Order::findOne($id);
        if(!$order){
            throw new NotFoundHttpException('Страница не найдена');
        }
        $order->recount();
        return $this->redirect(['update', 'id' => $id]);
    }

    public function actionRecountcancel($id){
        $order = Order::findOne($id);
        if(!$order){
            throw new NotFoundHttpException('Страница не найдена');
        }
        $order->recountcancel();
        return $this->redirect(['update', 'id' => $id]);
    }

    public function actionPrint($id){
        $order = Order::findOne($id);
        return $this->renderPartial('print', ['order' => $order]);
    }

}