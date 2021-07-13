<?php
/**
 * Created by PhpStorm.
 * User: resh
 * Date: 03.05.17
 * Time: 15:44
 */

namespace app\models;

use yii\data\ActiveDataProvider;

class UserSearch extends \dektrium\user\models\User
{

    public $name;
    public $phone;
    public $organization;
    public $location;
    public $inn;
    public $demo;
    public $suspicious;
    public $not_confirmed;
    public $not_active;

    public function rules()
    {
        $rules = parent::rules();
        $rules[] = [['name', 'phone', 'organization', 'location', 'inn', 'demo', 'suspicious', 'is_active', 'blocked_at', 'is_ignored', 'not_confirmed', 'not_active'], 'safe'];
        unset($rules['emailUnique']);
        return $rules;
    }
    

    public function search($params)
    {
        $query = $this->finder->getUserQuery();
        $query->joinWith('profile');
        $query->orderBy(['created_at' => SORT_DESC]);


        if (!($this->load($params) && $this->validate())) {
            //$query->andWhere(['not', ['confirmed_at' => null]]);
            $dataProvider = new ActiveDataProvider([
                'query' => $query,
                'sort' => false,
                'pagination' => [
                    'pageSize' => 50,
                ],
            ]);
            return $dataProvider;
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false
        ]);
        if ($this->created_at !== null) {
            $date = strtotime($this->created_at);
            $query->andFilterWhere(['between', 'created_at', $date, $date + 3600 * 24]);
        }

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['registration_ip' => $this->registration_ip])
            ->andFilterWhere(['like', 'concat(profile.lastname, " ", profile.name)', $this->name])
            ->andFilterWhere(['like', 'concat(profile.city, " ", profile.region)', $this->location])
            ->andFilterWhere(['like', 'username', $this->phone])
            ->andFilterWhere(['like', 'profile.inn', $this->inn])
            ->andFilterWhere(['like', 'profile.demo', $this->demo])
            ->andFilterWhere(['like', 'profile.suspicious', $this->suspicious])
            ->andFilterWhere(['like', 'profile.organization_name', $this->organization]);

        if($this->is_active){
            $query->andFilterWhere(['is_active' => 1])
            ->andWhere(['blocked_at' => null])
            ->andWhere(['is_ignored' => null]);
        }

        if($this->not_active){
            $query->andWhere(['is_active' => null])
            ->andWhere(['blocked_at' => null])
            ->andWhere(['is_ignored' => null]);
            //->andWhere(['not', ['confirmed_at' => null]]);
        }

        if($this->blocked_at){
            $query->andWhere(['not', ['blocked_at' => null]]);
        }

        if($this->is_ignored){
            $query->andWhere(['is_ignored' => 1]);
        }

        if($this->not_confirmed){
            $query->andWhere(['confirmed_at' => null]);
        }

        return $dataProvider;
    }

}