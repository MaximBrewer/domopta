<?php

/**
 * Created by PhpStorm.
 * User: resh
 * Date: 23.01.19
 * Time: 15:36
 */

namespace app\controllers;

use app\models\Category;
use app\models\User;
use app\models\Vk;
use yii\filters\AccessControl;
use yii\web\Controller;
use app\models\Products;

class CabinetController extends Controller
{

	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
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
		$user = User::findOne(\Yii::$app->user->id);
		$email = $user->email;
		$profile = $user->profile;
		if (!$user->profile->type) {
			return $this->redirect(['reg/full?step=1']);
		}
		$user->scenario = 'cabinet';
		if ($user->load(\Yii::$app->request->post()) && $user->save()) {
			$user = User::findOne(\Yii::$app->user->id);
			if ($user->email != $email) {
				$user->unconfirmed_email = 0;
				$user->save();
				if (!empty($user->email)) {
					$user->sendEmail('confirm');
				}
			}
			if (!\YII::$app->session->getFlash('no_success'))
				\YII::$app->session->setFlash('save_success');
			return $this->refresh();
		}
		return $this->render('index', ['user' => $user, 'profile' => $profile]);
	}

	public function actionCsv()
	{
		$user = User::findOne(\Yii::$app->user->id);
		$email = $user->email;
		$profile = $user->profile;
		if (!$user->profile->type) {
			return $this->redirect(['reg/full?step=1']);
		}
		$slug = \Yii::$app->request->get('slug', false);
		$this->catalogToCsv($slug);
		return \YII::$app->response->sendContentAsFile($this->catalogToCsv($slug), ($slug ? $slug : 'catalog') . ".csv");
	}

	public function actionXml()
	{
		$user = User::findOne(\Yii::$app->user->id);
		$email = $user->email;
		$profile = $user->profile;
		if (!$user->profile->type) {
			return $this->redirect(['reg/full?step=1']);
		}
		$slug = \Yii::$app->request->get('slug', false);
		$catalog = $this->getProducts($slug);
		return \YII::$app->response->sendContentAsFile($this->catalogToXml($slug), ($slug ? $slug : 'catalog') . ".xml");
	}

	private function catalogToCsv($slug)
	{
		$cache = \YII::$app->cache;
		$key = ($slug ? $slug : 'catalog') . '.csv';
		$content = $cache->get($key);
		if ($content === false) {
			$content .= "категория;бренд;название;цена;артикул;описание;размер;фото;цвет;" . PHP_EOL;
			$products = $this->getProducts($slug);
			if(!$products) $this->redirect(['/cabinet']);
			foreach ($products as $product) {
				foreach ($product as $v) {
					$content .= '"' . addslashes((is_array($v) ?  implode(";", $v) : $v)) .  '";';
				}
				$content .= PHP_EOL;
			}
			$cache->set($key, $content);
		}
		return $content;
	}

	private function catalogToXml($slug)
	{
		$cache = \YII::$app->cache;
		$key = ($slug ? $slug : 'catalog') . '.xml';
		$content = $cache->get($key);
		if ($content === false) {
			$data = $this->getProducts($slug);
			$cache->set($key, $content);
		}
		return $content;
	}

	private function getProducts($slug)
	{
		\YII::setAlias('@host', (\Yii::$app->request->isSecureConnection ? "https://" : "http://") . \Yii::$app->request->hostName);
		$cache = \YII::$app->cache;
		$key = ($slug ? $slug : 'catalog') . '.array';
		$products = $cache->get($key);
		if ($products === false) {
			if ($slug) {
				$category = Category::find()->where(['slug' => "/" . trim($slug, "/")])->one();
				if (!$category) return false;
				$categoryIds = $category->getAllChildrenIds();
				$data = Products::find()->where(['category_id' => $categoryIds])->all();
			} else {
				$data = Products::find()->all();
			}
			$products = [];
			foreach ($data as $product) {
				$products[] = [
					$product->category->name,
					$product->tradekmark,
					$product->name,
					$product->price,
					$product->article_index,
					$product->description,
					$product->size,
					array_map(function ($value) {
						return \Yii::getAlias('@host/upload/product/' . $value->folder . '/' . $value->image);
					}, $product->pictures),
					explode(",", $product->color),
				];
			}
			$cache->set($key, $products);
			$products = $cache->get($key);
		}
		return $products;
	}

	public function actionPassword()
	{
		$user = User::findOne(\Yii::$app->user->id);
		$profile = $user->profile;
		if (!$user->profile->type) {
			return $this->redirect(['reg/full?step=1']);
		}
		$user->scenario = 'password';
		if ($user->load(\Yii::$app->request->post()) && $user->save()) {
			$user = User::findOne(\Yii::$app->user->id);
			if (!\YII::$app->session->getFlash('no_success'))
				\YII::$app->session->setFlash('save_success');
			return $this->refresh();
		}
		return $this->render('password', ['user' => $user, 'profile' => $profile]);
	}

	public function actionSubscribe()
	{
		$model = Vk::findOne(['user_id' => \Yii::$app->user->id]);
		if (!$model) {
			$model = new Vk();
			$model->user_id = \Yii::$app->user->id;
		}
		if ($model->load(\Yii::$app->request->post()) && $model->save()) {
			return $this->refresh();
		}
		return $this->render('subscribe', ['model' => $model]);
	}

	public function actionResend()
	{
		$user = \Yii::$app->user->identity;
		if (!empty($user->email)) {
			$user->sendEmail('confirm');
		}
		return $this->redirect('/cabinet');
	}
}
