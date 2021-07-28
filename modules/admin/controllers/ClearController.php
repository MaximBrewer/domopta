<?php
/**
 * Created by PhpStorm.
 * User: resh
 * Date: 25.01.19
 * Time: 18:30
 */

namespace app\modules\admin\controllers;


use app\models\Order;
use app\models\Products;
use app\models\SendForm;
use yii\web\Controller;

class ClearController extends Controller {

	public function actionIndex(){
		if(\Yii::$app->request->post('products')){
		    $products_count = Products::find()->where('is_deleted=1 and deleted_date<' . (time() - 60*60*24*30*6))
                ->all();
		    \Yii::$app->session->addFlash('success', 'Удалено товаров всего: ' . count($products_count));
            //$products = Products::findAll('is_deleted=1 and deleted_date<' . (time() - 60*60*24*30*6));
            foreach ($products_count as $product){
                $product->delete();
            }
        }


        if(\Yii::$app->request->post('orders')){
            $orders_count = Order::find()->where('created_at < ' . (time() - 60*60*24*30*6))->all();
            \Yii::$app->session->addFlash('success', 'Удалено заказов: ' . count($orders_count));
            $orders = Order::findAll('created_at < ' . (time() - 60*60*24*30*6));
            foreach ($orders_count as $order){
                $order->delete();
            }
        }

		return $this->render('index');
	}

}