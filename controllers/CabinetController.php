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
use app\helpers\Inflector;

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
		\YII::$app->cache->flush();
		$user = User::findOne(\Yii::$app->user->id);
		if (!$user->profile->type) {
			return $this->redirect(['reg/full?step=1']);
		}
		$slug = \Yii::$app->request->get('slug', false);
		return \YII::$app->response->sendContentAsFile($this->catalogToCsv($slug, $user->profile->type), ($slug ? $slug : 'catalog') . "-domopta.ru.csv");
	}

	public function actionXml()
	{
		\YII::$app->cache->flush();
		$user = User::findOne(\Yii::$app->user->id);
		if (!$user->profile->type) {
			return $this->redirect(['reg/full?step=1']);
		}
		$slug = \Yii::$app->request->get('slug', false);
		return \YII::$app->response->sendContentAsFile($this->catalogToXml($slug, $user->profile->type), ($slug ? $slug : 'catalog') . "-domopta.ru.xml");
	}

	private function catalogToCsv($slug, $type)
	{
		$cache = \YII::$app->cache;
		$key = ($slug ? $slug : 'catalog') . '.' . $type . '.csv';
		$content = $cache->get($key);
		if ($content === false) {
			$content .= "Категория товаров;Наименование;Артикул;Цвет;Размеры;Состав;Товарный знак;К-во в Упак.;Цена;Цена за Уп.;Фото;ID Категории;Ссылка" . PHP_EOL;
			$products = $this->getProducts($slug, $type);
			if (!$products) $this->redirect(['/cabinet']);
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

	private function catalogToXml($slug, $type)
	{

		$cache = \YII::$app->cache;
		$key = ($slug ? $slug : 'catalog') . '.' . $type . '.xml';
		$content = $cache->get($key);
		if ($content === false) {

			$xmlstr = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<yml_catalog>
    <shop>
        <name>Легкий ветер</name>
        <company>Легкий ветер</company>
        <url>https://domopta.ru</url>
        <currencies>
            <currency id="RUR" rate="1"/>
        </currencies>
        <categories>
        </categories>
        <delivery-options>
        </delivery-options>
        <offers>
        </offers>
    </shop>
</yml_catalog>
XML;
			$yml = new \SimpleXMLElement($xmlstr);
			$yml->addAttribute('date', date(DATE_ATOM));

			$cats = Category::find()->all();
			foreach ($cats as $cat) {
				$category = $yml->shop->categories->addChild('category', $cat->name);
				$category->addAttribute('id', $cat->id);
				if ($cat->parent_id) $category->addAttribute('parentId', $cat->parent_id);
			}
			//Категория товаров;Наименование;Артикул;Цвет;Размеры;Состав;Товарный знак;К-во в Упак.;Цена;Цена за Уп.;Фото;ID Категории;Ссылка

			$products = $this->getProducts($slug, $type);
			if (!$products) $this->redirect(['/cabinet']);
			foreach ($products as $p) {
				$product = $yml->shop->offers->addChild('offer');
				$product->addChild('category', $p[0]);
				$product->addChild('name', $p[1]);
				$product->addChild('article', $p[2]);
				if(!empty($p[3])){
				$colors = $product->addChild('colors');
				foreach ($p[3] as $color) {
					$colors->addChild('color', $color);
				}}
				$product->addChild('size', $p[4]);
				$product->addChild('consist', $p[5]);
				$product->addChild('vendor', $p[6]);
				$product->addChild('pack_quantity', $p[7]);
				$product->addChild('price', $p[8]);
				$product->addChild('pack_price', $p[9]);
				$pictures = $product->addChild('pictures');
				foreach ($p[10] as $image) {
					$pictures->addChild('picture', $image);
				}
				$product->addChild('categoryId', $p[11]);
				$product->addChild('url', $p[12]);
			}

			$content = $yml->asXML();
			$cache->set($key, $content);
		}
		return $content;
	}

	private function getProducts($slug, $type)
	{
		\YII::setAlias('@host', (\Yii::$app->request->isSecureConnection ? "https://" : "http://") . \Yii::$app->request->hostName);
		$cache = \YII::$app->cache;
		$key = ($slug ? $slug : 'catalog') . '.' . $type . '.array';
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
			//Категория товаров;Наименование;Артикул;Цвет;Размеры;Состав;Товарный знак;К-во в Упак.;Цена;Цена за Уп.;Фото;ID Категории;Ссылка
			foreach ($data as $product) {
				$products[] = [
					htmlspecialchars($product->category->name), 				//0
					htmlspecialchars($product->name),							//1
					$product->article_index,									//2
					array_map(function ($value) {
						return htmlspecialchars($value);
					}, explode(",", $product->color)),							//3
					htmlspecialchars($product->size),							//4
					htmlspecialchars($product->consist),						//5
					htmlspecialchars($product->tradekmark),						//6
					$product->pack_quantity,									//7
					$type == 2 ? $product->price2 : $product->price,			//8
					$type == 2 ? $product->pack_price2 : $product->pack_price,	//9
					array_map(function ($value) {
						return \Yii::getAlias('@host/upload/product/' . $value->folder . '/' . $value->image);
					}, $product->pictures),										//10
					$product->category->id,										//11
					\Yii::getAlias('@host' . $product->slug),					//12
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
