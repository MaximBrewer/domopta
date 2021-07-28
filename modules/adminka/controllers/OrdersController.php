<?php

/**
 * Created by PhpStorm.
 * User: resh
 * Date: 16.05.17
 * Time: 10:33
 */

namespace app\modules\adminka\controllers;

use app\models\Order;
use app\models\User;
use app\models\OrderSearch;
use yii\web\Controller;
use dektrium\user\filters\AccessRule;
use yii\filters\AccessControl;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use yii\web\NotFoundHttpException;


class OrdersController extends Controller
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

    public function actionIndex()
    {
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        return $this->render('index', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider]);
    }



    public function actionReestr()
    {
        $model = \Yii::$app->request->post('OrderReestrForm');
        $from = $model['from'];
        $to = $model['to'];

        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Html();

        $timestampFrom = strtotime($from);
        $timestampTo = strtotime($to) + 24 * 3600;

        $spreadsheet = $reader->loadFromString($this->renderPartial('reestr', ['orders' => Order::find()->where("created_at > $timestampFrom AND created_at < $timestampTo")->all()]));
        $spreadsheet->getDefaultStyle()->getFont()->setSize(10);

        $style = $spreadsheet->getActiveSheet()->getStyle('A1:Z' . $spreadsheet->getActiveSheet()->getHighestRow());
        $style->getAlignment()->setWrapText(true);
        $style->getFont()->setSize(10);

        try {
            $writer = new Xlsx($spreadsheet);
            ob_start();
            $writer->save('php://output');
            $content = ob_get_clean();
            return \Yii::$app->response->sendContentAsFile($content, "РеестрЗаказов" . "-" . $from . "-" . $to . ".xlsx", ['mimeType' => 'application/x-unknown']);
        } catch (\PhpOffice\PhpSpreadsheet\Writer\Exception $e) {
            echo $e->getMessage();
        }
    }

    public function actionDelete()
    {
        $ids = \Yii::$app->request->post('selection');
        $models = Order::findAll(['id' => $ids]);
        foreach ($models as $model) {
            $model->delete();
        }
        return $this->redirect(['index']);
    }

    public function actionUpdate($id)
    {
        $order = Order::findOne($id);
        if (!$order) {
            throw new NotFoundHttpException('Страница не найдена');
        }
        return $this->render('update', ['order' => $order]);
    }

    public function actionRecount($id)
    {
        $order = Order::findOne($id);
        if (!$order) {
            throw new NotFoundHttpException('Страница не найдена');
        }
        $order->recount();
        return $this->redirect(['update', 'id' => $id]);
    }

    public function actionRecountcancel($id)
    {
        $order = Order::findOne($id);
        if (!$order) {
            throw new NotFoundHttpException('Страница не найдена');
        }
        $order->recountcancel();
        return $this->redirect(['update', 'id' => $id]);
    }

    public function actionPrint($id)
    {
        $order = Order::findOne($id);
        return $this->renderPartial('print', ['order' => $order]);
    }
}
