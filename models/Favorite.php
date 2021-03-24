<?php
/**
 * Created by PhpStorm.
 * User: resh
 * Date: 24.01.19
 * Time: 10:50
 */

namespace app\models;


use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property int $user_id
 * @property int product_id
 * @property User $user
 * @property Products $product
 */
class Favorite extends ActiveRecord {

	public static function tableName() {
		return '{{%favorite}}';
	}

	public function rules() {
		return [
			['user_id', 'integer'],
			['product_id', 'integer']
		];
	}

	public function getUser(){
		return $this->hasOne(User::className(), ['id' => 'user_id']);
	}

	public function getProduct(){
		return $this->hasOne(Products::className(), ['id' => 'product_id']);
	}

}