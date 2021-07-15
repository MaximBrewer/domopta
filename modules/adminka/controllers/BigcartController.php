<?php

/**
 * Created by PhpStorm.
 * User: resh
 * Date: 25.01.19
 * Time: 16:00
 */

namespace app\modules\adminka\controllers;

use Yii;
use app\models\Cart;
use app\models\User;
use app\models\Order;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class BigcartController extends Controller
{

	public function actionIndex()
	{
		$dataProvider = new ActiveDataProvider([
			'query' => User::find()->where('user.cart_sum >= 3000'),
			'pagination' => false
		]);
		return $this->render('index', ['dataProvider' => $dataProvider]);
	}

	public function actionCart($id)
	{
		return $this->render('cart', ['user' => User::findOne($id)]);
	}

	public function actionXls()
	{
		$reader = new \PhpOffice\PhpSpreadsheet\Reader\Html();

		// return $this->renderPartial('xls', ['users' => $users]);
		$spreadsheet = $reader->loadFromString($this->renderPartial('xls', ['users' => User::find()->where('user.cart_sum >= 3000')]));
		$spreadsheet->getDefaultStyle()->getFont()->setSize(10);

		$style = $spreadsheet->getActiveSheet()->getStyle('A1:A' . $spreadsheet->getActiveSheet()->getHighestRow());
		$style->getAlignment()->setWrapText(true);
		$style->getFont()->setSize(10);
		$style = $spreadsheet->getActiveSheet()->getStyle('B1:B' . $spreadsheet->getActiveSheet()->getHighestRow());
		$style->getAlignment()->setWrapText(true);
		$style->getFont()->setSize(10);
		$style = $spreadsheet->getActiveSheet()->getStyle('C1:C' . $spreadsheet->getActiveSheet()->getHighestRow());
		$style->getAlignment()->setWrapText(true);
		$style->getFont()->setSize(10);
		$style = $spreadsheet->getActiveSheet()->getStyle('D1:D' . $spreadsheet->getActiveSheet()->getHighestRow());
		$style->getAlignment()->setWrapText(true);
		$style->getFont()->setSize(10);
		$style = $spreadsheet->getActiveSheet()->getStyle('E1:E' . $spreadsheet->getActiveSheet()->getHighestRow());
		$style->getAlignment()->setWrapText(true);
		$style->getFont()->setSize(10);
		$style = $spreadsheet->getActiveSheet()->getStyle('F1:F' . $spreadsheet->getActiveSheet()->getHighestRow());
		$style->getAlignment()->setWrapText(true);
		$style->getFont()->setSize(10);
		$style = $spreadsheet->getActiveSheet()->getStyle('G1:G' . $spreadsheet->getActiveSheet()->getHighestRow());
		$style->getAlignment()->setWrapText(true);
		$style->getFont()->setSize(10);
		$style = $spreadsheet->getActiveSheet()->getStyle('H1:H' . $spreadsheet->getActiveSheet()->getHighestRow());
		$style->getAlignment()->setWrapText(true);
		$style->getFont()->setSize(10);

		try {
			$writer = new Xlsx($spreadsheet);
			ob_start();
			$writer->save('php://output');
			$content = ob_get_clean();
			return Yii::$app->response->sendContentAsFile($content, "Реестр заказов" . "-" . date("d") . "-" . date("m") . "-" . date("Y") . ".xlsx", ['mimeType' => 'application/x-unknown']);
		} catch (\PhpOffice\PhpSpreadsheet\Writer\Exception $e) {
			echo $e->getMessage();
		}
	}



	public function actionOrder($id)
	{
		$cart = Cart::findAll(['user_id' => $id]);
		$user = User::findOne($id);
		if (empty($cart)) return $this->redirect('/adminka/bigcart');

		if ($cart) {
			$order = new Order();
			$order->delivery_method = 'pickup';
			$order->scenario = 'pickup';
			$order->fio = $user->profile->name . ' ' . $user->profile->lastname . ' ' . $user->profile->surname . '(Корзина 3000)';
			$order->phone = '';
			$errors = Order::create($order, $cart, $id);
			if ($errors !== true)
				\Yii::$app->getSession()->setFlash('danger', $errors);
			else
				\Yii::$app->getSession()->setFlash('success', 'Заказ успешно оформлен');
			return $this->redirect('/adminka/bigcart');
		}
	}
}
