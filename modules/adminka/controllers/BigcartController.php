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
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class BigcartController extends Controller
{

	public function actionIndex()
	{
		$allcarts = Cart::find()->all();
		$users = [];
		foreach ($allcarts as $cart) {
			if (!isset($users[$cart->user_id])) {
				$users[$cart->user_id] = 0;
			}
			$users[$cart->user_id] += $cart->getSum();
		}
		$ids = [];
		foreach ($users as $id => $sum) {
			if ($sum >= 5000) {
				$ids[] = $id;
			}
		}
		$dataProvider = new ActiveDataProvider([
			'query' => User::find()->where(['id' => $ids]),
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
		$allcarts = Cart::find()->all();
		$users = [];
		foreach ($allcarts as $cart) {
			if (!isset($users[$cart->user_id])) {
				$users[$cart->user_id] = 0;
			}
			$users[$cart->user_id] += $cart->getSum();
		}
		$ids = [];
		foreach ($users as $id => $sum) {
			if ($sum >= 5000) {
				$ids[] = $id;
			}
		}
		$dataProvider = new ActiveDataProvider([
			'query' => User::find()->where(['id' => $ids]),
			'pagination' => false
		]);


		$reader = new \PhpOffice\PhpSpreadsheet\Reader\Html();
		$spreadsheet = $reader->loadFromString($this->renderPartial('xls', ['dataProvider' => $dataProvider]));

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
}
