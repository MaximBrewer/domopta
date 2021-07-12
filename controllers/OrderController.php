<?php

/**
 * Created by PhpStorm.
 * User: resh
 * Date: 13.05.17
 * Time: 16:30
 */

namespace app\controllers;

use app\models\Cart;
use app\models\Products;
use app\models\CartDetails;
use app\models\CartSearch;
use app\models\Order;
use app\models\User;
use app\models\Profile;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

class OrderController extends Controller
{

	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::class,
				'rules' => [
					[
						'allow' => true,
						'roles' => ['@'],
					],
				],
			],
		];
	}

	public function actionIndex()
	{
		$request = Yii::$app->request;
		$cart = Cart::findAll(['user_id' => Yii::$app->user->id]);
		if (empty($cart)) return $this->redirect('/');

		foreach ($cart as $item) {
			$product = $item->product;
			if (!$product)
				return $this->redirect('/cart');
			if (!$product->flag) {
				return $this->redirect('/cart');
				foreach ($item->details as $detail) {
					if ($detail->amount > 0) {
					} elseif ($detail->color != 'default' && !$product->hasColor($detail->color)) {
						return $this->redirect('/cart');
					}
				}
			}
		}

		if ($cart) {
			$order = new Order();
			if ($request->post('delivery_method')) {
				$order->scenario = $request->post('delivery_method');
				$order->delivery_method = $request->post('delivery_method');
				switch ($order->delivery_method) {
					case 'delivery':
						$order->locality = $request->post('locality');
						$order->fio = $request->post('fio');
						$order->phone = $request->post('phone');
						break;
					case 'sending':
						$order->tc = $request->post('tc');
						$order->passport_id = $request->post('passport_id');
						$order->city = $request->post('city');
						$order->region = $request->post('region');
						$order->passport_series = $request->post('passport_series');
						$order->fio = $request->post('fio2');
						$order->phone = $request->post('phone2');
						if ($order->tc == 'other')
							$order->tc_name = $request->post('tc_name');
						break;
					case 'pickup':
						$order->fio = '';
						$order->phone = '';
						break;
				}

				$errors = Order::create($order, $cart);
				if ($errors === true) {
					return $this->render('success');
				}
			}
			return $this->render('index', ['cart' => $cart, 'order' => $order]);
		}
		return $this->render('index');
	}
}
