<?php

/**
 * Created by PhpStorm.
 * User: resh
 * Date: 12.05.17
 * Time: 13:49
 */

namespace app\controllers;

use app\models\Category;
use app\models\Products;
use app\models\ProductsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\helpers\Json;

class CategoryController extends Controller
{
    public function actionIndex($id)
    {
        $session = \Yii::$app->session;
        $category = $this->getCategory($id);
        $searchModel = new ProductsSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams, $id);
        $session->set('cat_query_params', \Yii::$app->request->queryParams);
        $categories = Category::find()->where('parent_id IS NULL')->orderBy(['position' => SORT_ASC])->all();
        define("HIDE_FOOTER", true);
        if (\Yii::$app->request->isAjax) {
            $this->renderPartial('ajax', ['categories' => $categories, 'category' => $category, 'dataProvider' => $dataProvider, 'searchModel' => $searchModel]);
            echo Json::encode($this->view->blocks);
            die();
        } else {
            return $this->render('index', ['categories' => $categories, 'category' => $category, 'dataProvider' => $dataProvider, 'searchModel' => $searchModel]);
        }
    }

    public function getCategory($id)
    {
        $model = Category::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException('Страница не найдена');
        }
        return $model;
    }
}
