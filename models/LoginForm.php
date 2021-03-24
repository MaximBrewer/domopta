<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\base\Security;

class LoginForm extends Model
{

	public $login;
	public $password;

    public function rules()
    {
        return [
        	['login', 'required', 'message' => 'Введите номер телефона'],
	        ['password', 'required', 'message' => ''],
	        ['login', 'auth']
        ];
    }

    public function auth($attribute, $params){
	    $user = User::findOne(['username' => $this->login]);
	    if(!$user){
	        $this->addError('login', 'Данный номер телефона не зарегистрирован на сайте');
	        return false;
	    }
	    if($this->password == ''){
		    $this->addError('password', 'Введите пароль');
		    return false;
	    }
	    if(!Yii::$app->security->validatePassword($this->password, $user->password_hash)){
	    	$this->addError('password', 'Пароль введен не верно');
	    	return false;
	    }
	    Yii::$app->user->login($user, 60*60*24*30);
	    return true;
    }

}
