<?php

/**
 * Created by PhpStorm.
 * User: resh
 * Date: 23.01.19
 * Time: 15:36
 */

namespace app\controllers;


use app\models\User;
use app\models\Vk;
use yii\filters\AccessControl;
use yii\web\Controller;

class CabinetController extends Controller
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

	public function actionIndex()
	{
		$user = User::findOne(\Yii::$app->user->id);
		$email = $user->email;
		$profile = $user->profile;
		if (!$user->profile->type) {
			return $this->redirect(['reg/full?step=1']);
		}
		$user->scenario = 'cabinet';
		if ($user->load(\Yii::$app->request->post()) && $user->save()) {
			$user = User::findOne(\Yii::$app->user->id);
			if ($user->email != $email) {
				$user->unconfirmed_email = 0;
				$user->save();
				if (!empty($user->email)) {
					$user->sendEmail('confirm');
				}
			}
			if (!\YII::$app->session->getFlash('no_success'))
				\YII::$app->session->setFlash('save_success');
			return $this->refresh();
		}
		return $this->render('index', ['user' => $user, 'profile' => $profile]);
	}

	public function actionSubscribe()
	{
		$model = Vk::findOne(['user_id' => \Yii::$app->user->id]);
		if (!$model) {
			$model = new Vk();
			$model->user_id = \Yii::$app->user->id;
		}
		if ($model->load(\Yii::$app->request->post()) && $model->save()) {
			return $this->refresh();
		}
		return $this->render('subscribe', ['model' => $model]);
	}

	public function actionResend()
	{
		$user = \Yii::$app->user->identity;
		if (!empty($user->email)) {
			$user->sendEmail('confirm');
		}
		return $this->redirect('/cabinet');
	}
}
