<?php

/**
 * Created by PhpStorm.
 * User: resh
 * Date: 02.05.17
 * Time: 16:15
 */

namespace app\models;


class Profile extends \dektrium\user\models\Profile
{

    public function rules()
    {
        $rules = parent::rules();
        $rules[] = ['demo', 'integer'];
        $rules[] = ['type', 'required', 'message' => 'ДЛЯ ПРОДОЛЖЕНИЯ РЕГИСТРАЦИИ НЕОБХОДИМО ВЫБРАТЬ КАТЕГОРИЮ'];
        $rules[] = [['lastname', 'name'], 'required'];
        $rules[] = [['lastname', 'name', 'surname'], 'match', 'pattern' => '/[а-яА-ЯёЁ]+/u'];
        $rules[] = ['city', 'required'];
        $rules[] = ['region', 'required'];
        $rules[] = ['organization_name', 'required', 'when' => function ($model) {
            return in_array($model->type, [3]);
        }];
        $rules[] = ['location', 'required', 'when' => function ($model) {
            return in_array($model->type, [3]);
        }];
        $rules[] = ['inn', 'required', 'when' => function ($model) {
            return $model->type != 2;
        }];
        $rules[] = ['ogrn', 'safe'];

        $rules[] = ['inn', 'match', 'pattern' => '/(^[0-9]{10,15}$)/u'];

        $rules[] = [['lastname', 'name', 'surname'], 'filter', 'filter' => function ($value) {
            $str = mb_strtolower($value);
            return mb_strtoupper(mb_substr($str, 0, 1)) . mb_substr($str, 1);
        }];
        $rules[] = [['admins_comment', 'order_comment', 'suspicious', 'ogrn'], 'safe'];
        return $rules;
    }

    public function attributeLabels()
    {
        $attribute_lables = parent::attributeLabels();
        $attribute_lables['organization_name'] = 'Название ООО';
        $attribute_lables['phone'] = 'Телефон';
        $attribute_lables['inn'] = 'ИНН или ОГРН';
        $attribute_lables['lastname'] = 'Фамилия';
        $attribute_lables['surname'] = 'Отчество';
        $attribute_lables['city'] = 'Город';
        $attribute_lables['region'] = 'Регион';
        $attribute_lables['demo'] = 'Демо';
        $attribute_lables['suspicious'] = 'Подозрительный тип';
        $attribute_lables['users_comment'] = 'Комментарий пользователя';
        $attribute_lables['admins_comment'] = 'Комментарий админа';
        $attribute_lables['order_comment'] = 'Комментарий к заказу';
        $attribute_lables['type'] = 'Ценовая категория';
        $attribute_lables['location'] = 'Адрес';
        return $attribute_lables;
    }

    public function afterFind()
    {
        $this->lastname = mb_strtoupper($this->lastname);
        $this->surname = mb_strtoupper($this->surname);
        $this->name = mb_strtoupper($this->name);
        $this->organization_name = mb_strtoupper($this->organization_name);
        $this->city = mb_strtoupper($this->city);
        $this->region = mb_strtoupper($this->region);

        parent::afterFind();
    }
}
