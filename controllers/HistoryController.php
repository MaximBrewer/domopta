<?php

/**
 * Created by PhpStorm.
 * User: resh
 * Date: 24.01.19
 * Time: 18:12
 */

namespace app\controllers;


use app\models\Order;
use app\models\OrderSearch;
use app\modules\adminka\Module;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class HistoryController extends Controller
{

	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'rules' => [
					[
						'allow' => true,
						'roles' => ['@'],
					],
				],
			],
		];
	}

	public function actionXls($id)
	{
		$order = Order::findOne(['id' => $id, 'user_id' => Yii::$app->user->id]);
		// return Yii::$app->response->sendContentAsFile($this->renderPartial('xls', ['order' => $order]), "Заказ #" . $order->id . ".xls", ['mimeType' => 'application/x-unknown']);

		$reader = new \PhpOffice\PhpSpreadsheet\Reader\Html();
		$spreadsheet = $reader->loadFromString($this->renderPartial('xls', ['order' => $order]));

		try {
			$writer = new Xlsx($spreadsheet);
			ob_start();
			$writer->save('php://output');
			$content = ob_get_clean();
			return Yii::$app->response->sendContentAsFile($content, "Заказ-" . $order->id . "-" . date("d") . "-" . date("m") . "-" . date("Y") . ".xlsx", ['mimeType' => 'application/x-unknown']);
		} catch (\PhpOffice\PhpSpreadsheet\Writer\Exception $e) {
			echo $e->getMessage();
		}
	}

	public function actionIndex()
	{
		$orders = Order::find()->where(['user_id' => Yii::$app->user->id])->orderBy(['created_at' => SORT_DESC])->all();
		return $this->render('index', ['orders' => $orders]);
	}

	public function actionDetail($id)
	{
		$order = Order::findOne(['id' => $id, 'user_id' => Yii::$app->user->id]);
		return $this->render('detail', ['order' => $order]);
	}

	public function actionCancel($id)
	{
		$order = Order::findOne(['id' => $id, 'user_id' => Yii::$app->user->id, 'status' => 'pending']);
		if ($order) $order->updateAttributes(['status' => 'cancel']);
		$controller = new Controller('new', Module::className());
		$body = $controller->renderPartial('@app/modules/adminka/views/orders/email/admin', ['order' => $order]);
		$model = new Order;
		$model->mailer->sendEmail(Yii::$app->settings->get('Settings.adminEmail'), 'Заказ отменен', $body);
		$model->mailer->sendEmail(Yii::$app->settings->get('Settings.sellEmail'), 'Заказ отменен', $body);
		if ($order->user->unconfirmed_email == 1) {
			$body = $controller->renderPartial('@app/modules/adminka/views/orders/email/customer', ['order' => $order]);
			$model->mailer->sendEmail($order->user->email, 'Ваш Заказ отменен', $body);
		}
		return $this->redirect('/history');
	}

	public function actionReturn($id)
	{
		$order = Order::findOne(['id' => $id, 'user_id' => Yii::$app->user->id, 'status' => 'cancel']);
		if ($order) $order->updateAttributes(['status' => 'pending']);
		$controller = new Controller('new', Module::className());
		$body = $controller->renderPartial('@app/modules/adminka/views/orders/email/admin', ['order' => $order]);
		$model = new Order;
		$model->mailer->sendEmail(Yii::$app->settings->get('Settings.adminEmail'), 'Заказ восстановлен', $body);
		$model->mailer->sendEmail(Yii::$app->settings->get('Settings.sellEmail'), 'Заказ восстановлен', $body);
		if ($order->user->unconfirmed_email == 1) {
			$body = $controller->renderPartial('@app/modules/adminka/views/orders/email/customer', ['order' => $order]);
			$model->mailer->sendEmail($order->user->email, 'Ваш Заказ восстановлен', $body);
		}
		return $this->redirect('/history');
	}
}
