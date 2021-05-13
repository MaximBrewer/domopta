<?php

/**
 * Created by PhpStorm.
 * User: resh
 * Date: 19.12.18
 * Time: 15:31
 */

namespace app\controllers;


use app\models\InnValidator;
use app\models\MobRegForm;
use app\models\RegistrationForm;
use app\models\User;
use app\models\UserFile;
use yii\filters\AccessControl;
use yii\helpers\Json;
use app\models\Profile;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\widgets\ActiveForm;

class RegController extends Controller
{

	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'only' => ['full'],
				'rules' => [
					[
						'actions' => ['full'],
						'allow' => true,
						'roles' => ['@'],
					],
				],
			],
		];
	}

	public function actionStep1()
	{
		$model = new MobRegForm();
		$model->scenario = 'step1';
		return $this->renderAjax('step1', ['model' => $model]);
	}

	public function actionStep1validation()
	{
		$model = new MobRegForm();
		$model->scenario = 'step1';

		$model->load(\Yii::$app->request->post());
		$errors = ActiveForm::validate($model);
		if (!empty($errors)) {
			return Json::encode($errors);
		}
		$phone = str_replace('-', '', $model->phone);
		$phone = str_replace(' ', '', $phone);

		$user = User::find()->where(['username' => $phone])->one();
		if (!$user) {
			$user = new User();
			$user->mailer->mailerComponent = null;
			$user->username = $phone;
			$user->phone_code = rand(1000, 9999);
		}
		if ($user->createMob($user))
			return Json::encode([
				'success' => 1,
				'phone' => $user->username
			]);
	}


	public function actionStep2validation()
	{
		$model = new MobRegForm();
		$model->scenario = 'step2';

		$model->load(\Yii::$app->request->post());
		$errors = ActiveForm::validate($model);
		if (!empty($errors)) {
			return Json::encode($errors);
		}

		$user = User::findOne(['username' => $model->phone2, 'phone_code' => $model->code]);
		if ($user) {
			$user->confirm();

			\Yii::$app->user->login($user);

			return $this->redirect('/reg/full?step=1');

			return Json::encode([
				'success' => 1,
				'phone' => $user->username
			]);
		}
		return Json::encode([
			'mobregform-code' => 'Неверно указан код из смс!'
		]);
	}

	public function actionFull($step, $type = 0)
	{
		$user = User::findOne(\Yii::$app->user->id);
		$profile = $user->profile;
		if ($profile->name) return $this->redirect(['/user/settings/networks']);
		switch ($step) {
			case 1:
				if (in_array($type, [1, 2, 3])) {
					\Yii::$app->db->createCommand('UPDATE ' . Profile::tableName() . ' SET type=:type WHERE user_id=:user_id')
						->bindValue(':type', $type)
						->bindValue(':user_id', $profile->user_id)
						->execute();
					return $this->redirect('/reg/full?step=2');
				}
				if ($profile->type) return $this->redirect(['reg/full', 'step' => 2]);
				return $this->render('full/step1', ['user' => $user, 'profile' => $profile]);
				break;
			case 2:
				if (!$profile->type) return $this->redirect(['reg/full', 'step' => 1]);
				if ($user->load(\Yii::$app->request->post()) & $profile->load(\Yii::$app->request->post())) {
					$user->docs = UploadedFile::getInstances($user, 'docs');
					if ($profile->type == 3) {
						$user->flags = 1;
					}
					if ($user->validate() && $profile->validate() && InnValidator::validate($user, $profile)) {
						$user->save();
						$profile->save();
						foreach ($user->docs as $doc) {
							$name = uniqid() . '.' . $doc->extension;
							$doc->saveAs('upload/docs/' . $name);
							$file = new UserFile();
							$file->user_id = $user->id;
							$file->filename = $name;
							$file->save();
						}
						if (!empty($user->email)) {
							$user->sendEmail('confirm');
						}
						\Yii::$app->session->setFlash('reg-success');
						$user->activate();
						return $this->redirect(['/user/settings/networks']);
					}
				}
				return $this->render('full/step2', ['user' => $user, 'profile' => $profile]);
				break;
			default:
				break;
		}
	}
}
