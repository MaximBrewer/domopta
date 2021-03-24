<?php
/**
 * Created by PhpStorm.
 * User: resh
 * Date: 13.05.17
 * Time: 16:32
 */

namespace app\models;


use yii\data\ActiveDataProvider;

class CartSearch extends Cart
{

    public function search(){

        $query = Cart::find()
            ->innerJoinWith('details')
            ->where(['user_id' => \Yii::$app->user->id])
            ->andFilterWhere(['>', '{{%cart_details}}.amount', 0])
            ->orderBy(['article' => SORT_ASC])->all();
//        $dataProvider = new ActiveDataProvider([
//            'query' => $query,
//            'pagination' => false,
//            'sort' => false
//        ]);

        return $query;
    }

}