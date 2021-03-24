<?php
/**
 * Created by PhpStorm.
 * User: resh
 * Date: 08.05.17
 * Time: 15:37
 */

namespace app\models;


use yii\data\ActiveDataProvider;

class PageSearch extends Page
{

    public function search($params){
        $query = Page::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['name' => SORT_ASC]
            ],
            'pagination' => false
        ]);

        if(!($this->load($params) && $this->validate())){
            return $dataProvider;
        }

        return $dataProvider;

    }


}