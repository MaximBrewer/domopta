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
use app\helpers\Inflector;

class SearchForm extends Model
{

    public $text;

    public function rules()
    {
        return [
            ['text', 'safe']
        ];
    }

    public function search()
    {
        $this->text = trim($this->text);
        $trans = Inflector::transliterate($this->text);
        $query = Products::find()
            ->where(['like', 'name', $this->text])
            ->orWhere(['like', 'article_index', $this->text])
            ->orWhere(['like', 'article_index', $trans])
            ->orWhere(['like', 'article_index', $trans])
            ->andWhere(['is_deleted' => 0])
            ->orderBy('article_index');

        // var_dump($query->prepare(\Yii::$app->db->queryBuilder)->createCommand()->rawSql);
        // die;
        if (!\Yii::$app->user->isGuest && \Yii::$app->user->identity->flags == 1) {
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
