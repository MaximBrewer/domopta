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
use app\models\Import;
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
		if (\Yii::$app->request->get('flush', false))
			\YII::$app->cache->flush();
		$user = User::findOne(\Yii::$app->user->id);
		if (!$user->profile->type) {
			return $this->redirect(['reg/full?step=1']);
		}
		$slug = \Yii::$app->request->get('slug', false);
		$import = new Import();
		$import->type = 1;
		$import->user_id = $user->id;
		$import->save();
		return \YII::$app->response->sendContentAsFile(iconv("UTF-8", "windows-1251", $this->catalogToCsv($slug, $user->profile->type)), ($slug ? $slug : 'catalog') . "-domopta.ru.csv");
	}


	public function actionXml()
	{
		if (\Yii::$app->request->get('flush', false))
			\YII::$app->cache->flush();
		$user = User::findOne(\Yii::$app->user->id);
		if (!$user->profile->type) {
			return $this->redirect(['reg/full?step=1']);
		}
		$slug = \Yii::$app->request->get('slug', false);
		$import = new Import();
		$import->type = 2;
		$import->user_id = $user->id;
		$import->save();
		return \YII::$app->response->sendContentAsFile($this->catalogToXml($slug, $user->profile->type), ($slug ? $slug : 'catalog') . "-domopta.ru.xml");
	}

	private function catalogToCsv($slug, $type)
	{
		$cache = \YII::$app->cache;
		$key = ($slug ? $slug : 'catalog') . '.' . $type . '.csv';
		$content = $cache->get($key);
		if ($content === false) {
			$content .= "Категория товаров;Наименование;Артикул;Цвет;Размеры;Состав;Товарный знак;К-во в Упак.;Цена;Цена за Уп.;Фото;ID Категории;Ссылка;Описание(html);Описание(текст)" . PHP_EOL;
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
				$product->addChild('color', $p[3]);
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
				$description = $product->addChild('description');
				$this->addCDataToNode($description, $p[13]);
			}

			$content = $yml->asXML();
			$cache->set($key, $content);
		}
		return $content;
	}

    private function addCDataToNode(\SimpleXMLElement &$node, $value = '')
    {
        if ($domElement = dom_import_simplexml($node))
        {
            $domOwner = $domElement->ownerDocument;
            $domElement->appendChild($domOwner->createCDATASection("{$value}"));
        }
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
				if ($type == 3)
					$data = Products::findAll(['category_id' => $categoryIds, 'ooo' => 1, 'flag' => 1, 'is_deleted' => 0]);
				else
					$data = Products::findAll(['category_id' => $categoryIds, 'flag' => 1, 'is_deleted' => 0]);
			} else {
				if ($type == 3)
					$data = Products::findAll(['ooo' => 1, 'flag' => 1, 'is_deleted' => 0]);
				else
					$data = Products::findAll(['flag' => 1, 'is_deleted' => 0]);
			}
			$products = [];
			//Категория товаров;Наименование;Артикул;Цвет;Размеры;Состав;Товарный знак;К-во в Упак.;Цена;Цена за Уп.;Фото;ID Категории;Ссылка
			foreach ($data as $product) {
				$colors = array_map(function ($value) {
					return htmlspecialchars($value);
				}, explode(",", $product->color));
				foreach ($colors as $color) {
					$products[] = [
						htmlspecialchars($product->category->name), 				//0
						htmlspecialchars($product->name),							//1
						$product->article_index,									//2
						$color,														//3
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
						htmlspecialchars($product->description),					//13
						strip_tags($product->description)							//14
					];
				}
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
