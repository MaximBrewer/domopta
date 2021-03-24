<?php
/**
 * Created by PhpStorm.
 * User: resh
 * Date: 24.01.19
 * Time: 12:54
 */

namespace app\models;


use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\Cookie;

/**
 * @property int $id
 * @property int $user_id
 * @property int $product_id
 * @property int $viewed_at
 */
class ProductViews extends ActiveRecord {

	public static function tableName() {
		return '{{%product_view}}';
	}

	public function rules() {
		return [
			['user_id', 'integer'],
			['product_id', 'integer'],
			['viewed_at', 'integer'],
		];
	}

	public static function view($product_id){
		if(!\Yii::$app->user->isGuest){
			$model = ProductViews::findOne(['product_id' => $product_id, 'user_id' => \Yii::$app->user->id]);
			if(!$model){
				$model = new ProductViews();
				$model->user_id = \Yii::$app->user->id;
				$model->product_id = $product_id;
			}
			$model->viewed_at = time();
			$model->save();
			$models = ProductViews::find()->where(['product_id' => $product_id, 'user_id' => \Yii::$app->user->id])
				->orderBy(['viewed_at' => SORT_DESC])
				->offset(50)
				->all();
			foreach ($models as $model){
				$model->delete();
			}
		} else {
			$cookies = \Yii::$app->request->cookies;
			$view = null;
			if(isset($cookies['views'])){
				$views = Json::decode($cookies['views']);
				foreach ($views as $key => $item){
					if($item['product_id'] == $product_id){
						$view = $item;
						break;
					}
				}
				if($view){
					$views[$key]['viewed_at'] = time();
				} else {
					$views[] = [
						'product_id' => $product_id,
						'viewed_at' => time()
					];
				}
//				$cookies->remove('views');
			} else {
				$views[] = [
					'product_id' => $product_id,
					'viewed_at' => time()
				];
			}
			\Yii::$app->response->cookies->add(new Cookie(['name' => 'views', 'value' => Json::encode($views)]));
		}
	}

	public static function getProducts(){
		if(!\Yii::$app->user->isGuest){
			$ids = ArrayHelper::map(ProductViews::find()
			                                    ->where(['user_id' => \Yii::$app->user->id])
			                                    ->orderBy(['viewed_at' => SORT_DESC])->all(), 'id', 'product_id');
		} else {
			$cookies = \Yii::$app->request->cookies;
			$ids = [];
			if(isset($cookies['views'])) {
				$views = Json::decode( $cookies['views'] );
				foreach ($views as $item){
					$ids[$item['viewed_at']] = $item['product_id'];
				}
				krsort($ids);
			}
		}
		$products = [];
		foreach ($ids as $id){
			$product = Products::findOne($id);
			if($product) {
				$products[] = $product;
			}
			if(count($products) >= 50) {
				break;
			}
		}

		return $products;
	}

}