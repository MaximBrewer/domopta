<?php

/**
 * Created by PhpStorm.
 * User: resh
 * Date: 24.01.19
 * Time: 10:56
 */

namespace app\controllers;


use app\models\Category;
use app\models\Favorite;
use app\models\FavoriteSearch;
use yii\helpers\Json;
use yii\filters\AccessControl;
use yii\web\Controller;

class FavoritesController extends Controller
{

	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::class,
				'rules' => [
					[
						'allow' => true,
						'roles' => ['@'],
					],
				],
			],
		];
	}

	public function actionIndex()
	{
		$searchModel = new FavoriteSearch();
		$dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
		$categories = Category::find()->where('parent_id IS NULL')->orderBy(['position' => SORT_ASC])->all();
		return $this->render('index', ['dataProvider' => $dataProvider, 'searchModel' => $searchModel, 'categories' => $categories]);
	}

	public function actionAdd($product_id)
	{
		if (\Yii::$app->user->isGuest) return;
		$model = Favorite::findOne(['product_id' => $product_id, 'user_id' => \Yii::$app->user->id]);
		if (!$model) {
			$model             = new Favorite();
			$model->product_id = $product_id;
			$model->user_id    = \Yii::$app->user->id;
			$model->save();
		}
		return Json::encode([
			'count' => \Yii::$app->user->identity->getFavoritesAmount(),
			'html' => $this->renderPartial('add')
		]);
	}

	public function actionRemove($product_id)
	{
		Favorite::deleteAll(['product_id' => $product_id, 'user_id' => \Yii::$app->user->id]);
	}
}
