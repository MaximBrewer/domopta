<?php
/**
 * Created by PhpStorm.
 * User: resh
 * Date: 19.12.18
 * Time: 15:29
 */

namespace app\models;


use himiklab\yii2\recaptcha\ReCaptchaValidator;
use miserenkov\validators\PhoneValidator;
use yii\base\Model;

class ForgotForm extends Model
{

	public $phone;
	public $recaptcha;//

	public function rules() {
		return [
			['recaptcha', ReCaptchaValidator::className(), 'message' => 'Подтвердите, что вы не робот'],
			['phone', 'required', 'message' => 'Введите номер телефона'],
			['phone', 'checkPhone'],

		];
	}

	public function attributeLabels() {
		return [
//			'agree' => '<span>Я согласен с обработкой персональных данных и <a href="#">политикой конфедициальности</a></span>'
		];
	}

	public function scenarios() {
		return [
			'step1' => ['phone', 'recaptcha'],
		];
	}

	public function checkPhone($attribute, $params){
		$phone = str_replace('-', '', $this->phone);
		$phone = str_replace('(', '', $phone);
		$phone = str_replace(')', '', $phone);
		$phone = str_replace(' ', '', $phone);
		$user = User::findOne(['username' => $phone]);
		if (!$user){
			$this->addError('phone', 'Данный номер телефона не зарегистрирован');
			return false;
		}
		if ($user->isBlocked){
			$this->addError('phone', 'Пользователь заблокирован');
			return false;
		}
		return true;
	}

}