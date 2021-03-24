<?php
/**
 * Created by PhpStorm.
 * User: resh
 * Date: 23.01.19
 * Time: 11:55
 */

namespace app\controllers;


use app\models\LoginForm;
use yii\helpers\Json;
use yii\web\Controller;
use yii\widgets\ActiveForm;

class LoginController extends Controller {

	public function actionIndex(){
		$model = new LoginForm();
		return $this->renderAjax('index', ['model' => $model]);
	}

	public function actionValidate(){
		$model = new LoginForm();
		$model->load(\Yii::$app->request->post());
		$model->login = str_replace('(', '', $model->login);
		$model->login = str_replace(')', '', $model->login);
		$model->login = str_replace(' ', '', $model->login);
		$model->login = str_replace('-', '', $model->login);

		$errors = ActiveForm::validate($model);
		if(!empty($errors)) {
			return Json::encode( $errors );
		}
		return Json::encode([
			'success' => 1,
			'id' => \Yii::$app->user->id
		]);
	}

	public function actionForgot(){

	}

}