<?php

/**
 * Created by PhpStorm.
 * User: resh
 * Date: 19.12.18
 * Time: 15:29
 */

namespace app\models;


use miserenkov\validators\PhoneValidator;
use yii\base\Model;

class MobRegForm extends Model
{

	public $phone;
	public $phone2;
	public $code;
	public $agree;

	public function rules()
	{
		return [
			['phone', 'required', 'message' => 'Введите номер телефона'],
			['phone2', 'required'],
			['phone', PhoneValidator::className(), 'country' => 'RU', 'notValidPhoneNumberMessage' => 'Не верный формат номера телефона', 'numberParseExceptionMessage' => 'Не верный формат номера телефона'],
			['phone', 'checkUnique'],
			['agree', 'required'],
			['agree', 'compare', 'compareValue' => 1]
		];
	}

	public function attributeLabels()
	{
		return [
			'agree' => '<span>Я согласен с обработкой персональных данных и <a href="#">политикой&nbsp;конфедициальности</a></span>'
		];
	}

	public function scenarios()
	{
		return [
			'step1' => ['phone', 'agree'],
			'step2' => ['phone2', 'code'],
		];
	}

	public function checkUnique($attribute, $params)
	{
		$phone = str_replace('(', '', $this->phone);
		$phone = str_replace(')', '', $phone);
		$phone = str_replace(' ', '', $phone);
		$phone = str_replace('-', '', $phone);

		$user = User::find()->where(['username' => $phone])->andWhere(['not', ['confirmed_at' => null]])->one();
		if ($user) {
			$this->addError('phone', 'Номер телефона уже зарегистрирован <a href="#" class="log-pop__recovery-link2">Забыли пароль?</a>');
		}
	}
}
