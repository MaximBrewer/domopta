<?php

/**
 * Created by PhpStorm.
 * User: resh
 * Date: 03.05.17
 * Time: 15:44
 */

namespace app\models;

use yii\data\ActiveDataProvider;

class BigCart extends \dektrium\user\models\User
{
    
    public function attributes()
    {
        // делаем поле зависимости доступным для поиска
        return array_merge(parent::attributes(), ['profile.lastname', 'profile.city', 'profile.region']);
    }

    public function rules()
    {
        $rules = parent::rules();
        $rules[] = [['profile.lastname', 'profile.city', 'profile.region'], 'safe'];
        unset($rules['emailUnique']);
        return $rules;
    }


    public function search($params)
    {
        $query = $this->finder->getUserQuery();
        $query->where('user.cart_sum >= 3000');
        $query->joinWith('profile');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['username' => SORT_ASC],
                'params' => \Yii::$app->getRequest()->get(),
                'attributes' => [
                    'username',
                    'profile.lastname',
                    'cart_sum',
                    'profile.type',
                    'profile.city',
                    'profile.region'
                ],
            ],
        ]);

        var_dump(\Yii::$app->getRequest()->get());

        $query->andFilterWhere(['like', 'profile.lastname', $this->lastname]);

        return $dataProvider;
    }
}
