<?php
/**
 * Created by PhpStorm.
 * User: resh
 * Date: 11.05.17
 * Time: 12:24
 */

namespace app\models;


use yii\data\ActiveDataProvider;

class NewsSearch extends News
{

    public $all;

    public function rules()
    {
        return [
            ['all', 'safe'],
        ];
    }

    public function search($params){
        $query = News::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['created_at' => SORT_DESC]
            ],
            'pagination' => [
                'defaultPageSize' => 12
            ]
        ]);

        $this->load($params);
        if(!$this->validate()){
            return $dataProvider;
        }

        if($this->all){
            $dataProvider->pagination = false;
        }

        return $dataProvider;

    }

}