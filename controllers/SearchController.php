<?php
/**
 * Created by PhpStorm.
 * User: resh
 * Date: 19.05.17
 * Time: 13:25
 */

namespace app\controllers;

use app\models\Category;
use app\models\SearchForm;
use yii\web\Controller;
use Yii;

class SearchController extends Controller
{

    public function actionIndex(){
        $searchModel = new SearchForm();
        $searchModel->load(Yii::$app->request->queryParams);
        $dataProvider = $searchModel->search();
	    $categories = Category::find()->where('parent_id IS NULL')->orderBy(['position' => SORT_ASC])->all();
        return $this->render('index', ['dataProvider' => $dataProvider, 'searchModel' => $searchModel, 'categories' => $categories]);
    }

}