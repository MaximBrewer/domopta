<?php
namespace app\widgets\productviews;

use app\models\ProductViews;

class ProductViewWidget extends \yii\base\Widget {

	public function run() {
		$products = ProductViews::getProducts();
		return $this->render('views', ['products' => $products]);
	}

}