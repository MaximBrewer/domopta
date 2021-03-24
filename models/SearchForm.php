<?php
/**
 * Created by PhpStorm.
 * User: resh
 * Date: 19.05.17
 * Time: 12:44
 */

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class SearchForm extends Model
{

    public $text;

    public function rules()
    {
        return [
            ['text', 'safe']
        ];
    }

    public function search(){
        $this->text = trim($this->text);
        $query = Products::find()
            ->where(['or',['like', 'name' , $this->text], ['like', 'article_index' , $this->text]])
	        ->andWhere(['is_deleted' => 0])
            ->orderBy('article_index');
        if(!\Yii::$app->user->isGuest && \Yii::$app->user->identity->flags == 1){
            $query->andWhere(['ooo' => 1]);
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 50
            ],
            'sort' => false
        ]);
        return $dataProvider;
    }

}