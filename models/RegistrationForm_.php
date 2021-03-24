<?php
/**
 * Created by PhpStorm.
 * User: resh
 * Date: 04.05.17
 * Time: 13:19
 */

namespace app\models;

use app\models\Profile;
use dektrium\user\models\RegistrationForm as BaseRegistrationForm;
//use dektrium\user\models\User as BaseUser;

class RegistrationForm extends BaseRegistrationForm
{
    /**
     * Add a new field
     * @var string
     */
    public $type;
    public $lastname;
    public $name;
    public $surname;
    public $city;
    public $region;
    public $organization_name;
    public $phone;
    public $inn;
    public $users_comment;
    public $capcha;
    public $agree;
    public $password_repeat;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = parent::rules();
        $rules[] = ['type', 'required'];
        $rules[] = ['type', 'in', 'range' => ['ip', 'ooo', 'sp']];
        $rules[] = [['lastname', 'name', 'surname'], 'required'];
        $rules[] = [['lastname', 'name', 'surname'], 'match', 'pattern' => '/[а-яА-ЯёЁ]+/u', 'message' => 'В поле «{attribute}» допустимы только русские буквы.'];
        $rules[] = ['city', 'required'];
        $rules[] = ['region', 'required'];
        $rules[] = ['phone', 'required'];
        $rules[] = ['phone', 'default'];
        $rules[] = ['organization_name', 'required', 'when' => function($model){
            return in_array($model->type, ['ooo']);
        }];
        $rules[] = ['inn', 'required', 'when' => function($model){
            return in_array($model->type, ['ip', 'ooo']);
        }];

        $rules[] = ['inn', 'match', 'pattern' => '/(^[0-9]{10}$|^[0-9]{12}$|^[0-9]{15}$)/u', 'message' => 'Поле «{attribute}» должен быть длинной 10, 12, или 15 символов.'];
        $rules[] = ['users_comment', 'safe'];
//        $rules[] = ['capcha', 'captcha', 'captchaAction' => '/site/captcha'];
        $rules[] = ['agree', 'required', 'message' => 'Чтобы пройти регистрацию нужно ознакомится с Условиями использования сайта и дать свое согласие на хранение и обработку своих данных'];
        $rules[] = ['agree', 'compare', 'compareValue' => 1, 'message' => 'Чтобы пройти регистрацию нужно ознакомится с Условиями использования сайта и дать свое согласие на хранение и обработку своих данных'];
        $rules[] = ['password_repeat', 'required'];
        $rules[] = ['password_repeat', 'compare', 'compareAttribute' => 'password'];
        $rules[] = [['lastname', 'name', 'surname', 'city', 'region'], 'filter', 'filter' => function($value){
            $str = mb_strtolower($value);
            return mb_strtoupper(mb_substr($str, 0, 1)) . mb_substr($str, 1);
        }];
        unset($rules['usernameRequired']);
        return $rules;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $labels = parent::attributeLabels();
        $labels['type'] = 'Тип организации';
        $labels['lastname'] = 'Фамилия';
        $labels['name'] = 'Имя';
        $labels['surname'] = 'Отчество';
        $labels['city'] = 'Город';
        $labels['region'] = 'Область';
        $labels['organization_name'] = 'Название организации';
        $labels['phone'] = 'Телефон';
        $labels['inn'] = 'ИНН';
        $labels['users_comment'] = 'Комментарий';
        $labels['capcha'] = 'Код с картинки';
        $labels['password_repeat'] = 'Подтвердите пароль';
        $labels['agree'] = '';
        return $labels;
    }

    /**
     * @inheritdoc
     */
    public function loadAttributes(\dektrium\user\models\User $user)
    {
        // here is the magic happens
        $user->setAttributes([
            'email'    => $this->email,
            'username' => $this->username,
            'password' => $this->password,
            'password' => $this->password,
        ]);
        /** @var Profile $profile */
        $profile = \Yii::createObject(Profile::className());
        $profile->setAttributes([
            'type' => $this->type,
            'lastname' => $this->lastname,
            'name' => $this->name,
            'surname' => $this->surname,
            'city' => $this->city,
            'region' => $this->region,
            'organization_name' => $this->organization_name,
            'phone' => $this->phone,
            'inn' => $this->inn,
            'users_comment' => $this->users_comment,
        ]);
        $user->setProfile($profile);
    }


    public function beforeValidate()
    {
        $this->username = $this->email;
        return true;
    }
}
