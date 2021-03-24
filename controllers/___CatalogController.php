<?php
/**
 * Created by PhpStorm.
 * User: resh
 * Date: 31.05.17
 * Time: 14:09
 */

namespace app\controllers;

use app\models\ProductsSearch;
use yii\web\Controller;
use app\models\Category;

class CatalogController extends Controller
{
    public function actionIndex(){
        $categories = Category::find()->where('parent_id IS NULL')->orderBy(['position' => SORT_ASC])->all();
	    $searchModel = new ProductsSearch();
	    $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        return $this->render('index', ['categories' => $categories, 'dataProvider' => $dataProvider, 'searchModel' => $searchModel]);
    }
}