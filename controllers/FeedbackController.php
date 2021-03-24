<?php
/**
 * Created by PhpStorm.
 * User: resh
 * Date: 24.01.19
 * Time: 19:34
 */

namespace app\controllers;


use app\models\ContactForm;
use yii\web\Controller;

class FeedbackController extends Controller {

	public function actionIndex(){
		$model = new ContactForm();
		if ($model->load(\Yii::$app->request->post()) && $model->contact(0, 'Письмо с формы Написать администрации')) {
			\Yii::$app->session->setFlash('contactFormSubmitted');

			return $this->refresh();
		}
		return $this->render('contact', [
			'model' => $model,
			'title' => 'Написать администрации'
		]);
	}

	public function actionKp(){
		$model = new ContactForm();
		if ($model->load(\Yii::$app->request->post()) && $model->contact(0, 'Письмо с формы Отправить коммерческое предложение')) {
			\Yii::$app->session->setFlash('contactFormSubmitted');

			return $this->refresh();
		}
		return $this->render('contact', [
			'model' => $model,
			'title' => 'Отправить коммерческое предложение'
		]);
	}

	public function actionOrder(){
		$model = new ContactForm();
		if ($model->load(\Yii::$app->request->post()) && $model->contact(1, 'Письмо с формы Написать в отдел заказов')) {
			\Yii::$app->session->setFlash('contactFormSubmitted');

			return $this->refresh();
		}
		return $this->render('contact', [
			'model' => $model,
			'title' => 'Написать в отдел заказов'
		]);
	}

}