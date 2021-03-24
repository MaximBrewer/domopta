<?php
/**
 * Created by PhpStorm.
 * User: resh
 * Date: 12.05.17
 * Time: 10:35
 */

namespace app\models;

use yii\data\ActiveDataProvider;
class MenuSearch extends Menu
{

    public function search($params){
        $query = Menu::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['order' => SORT_ASC]
            ]
        ]);

        if(!($this->load($params) && $this->validate())){
            return $dataProvider;
        }

        return $dataProvider;

    }

}