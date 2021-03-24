<?php
/**
 * Created by PhpStorm.
 * User: resh
 * Date: 16.05.17
 * Time: 12:29
 */

namespace app\models;


use yii\data\ActiveDataProvider;

class OrderDetailsSearch extends OrderDetails
{

    public function rules()
    {
        return [];
    }

    public function search($order_id ,$params = []){
        $query = OrderDetails::find()->where(['order_id' => $order_id])
        ->orderBy('article');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false,
            'pagination' => false
        ]);
        return $dataProvider;
    }

}