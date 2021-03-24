<?php
/**
 * Created by PhpStorm.
 * User: resh
 * Date: 24.01.19
 * Time: 11:00
 */

namespace app\models;


use yii\data\ActiveDataProvider;

class FavoriteSearch extends Favorite {

	public function search($params){
		$ids_1 = Favorite::find()->select('product_id')->where(['user_id' => \Yii::$app->user->id])->asArray()->all();
		$ids = [];
		foreach ($ids_1 as $id){
			$ids[] = $id['product_id'];
		}

		$query = Products::find()->where(['id' => $ids, 'is_deleted' => 0]);
		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'pagination' => [
				'pageSize' => 12
			]
		]);

		$this->load($params);

		if(!$this->validate()){
			return $dataProvider;
		}

		return $dataProvider;

	}

}