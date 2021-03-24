<?php
/**
 * Created by PhpStorm.
 * User: resh
 * Date: 16.05.17
 * Time: 10:36
 */

namespace app\models;


use yii\data\ActiveDataProvider;

class OrderSearch extends Order
{

    public $name;
    public $ooo;

    public function rules()
    {
        return [
            [['id', 'name', 'ooo'], 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'ooo' => 'ООО',
        ];
    }

    public function search($params){
        $query = Order::find()->joinWith('user')
            ->joinWith('user.profile')
            ->orderBy(['created_at' => SORT_DESC]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false
        ]);

        $this->load($params);
        if(!$this->validate()){
            return $dataProvider;
        }

        $query->andFilterWhere(['{{%order}}.id' => $this->id])
        ->andFilterWhere(['like', 'concat(profile.lastname, " ", profile.name, " ", profile.surname)', $this->name])
        ->andFilterWhere(['like', 'profile.organization_name', $this->ooo]);

        return $dataProvider;

    }

	public function searchOwn($params){
		$query = Order::find()->where(['user_id' => \Yii::$app->user->id])
		              ->orderBy(['created_at' => SORT_DESC]);
		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'sort' => false
		]);

		$this->load($params);
		if(!$this->validate()){
			return $dataProvider;
		}

		return $dataProvider;

	}

}