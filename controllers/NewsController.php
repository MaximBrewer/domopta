<?php
/**
 * Created by PhpStorm.
 * User: resh
 * Date: 12.05.17
 * Time: 13:49
 */

namespace app\controllers;

use app\models\Category;
use app\models\News;
use app\models\NewsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class NewsController extends Controller
{

    public function actionIndex($id = null){
        if(!$id){
            $searchModel = new NewsSearch();
            $dataProvfider = $searchModel->search(\Yii::$app->request->queryParams);
            return $this->render('list', ['dataProvider' => $dataProvfider, 'searchModel' => $searchModel]);
        } else {
            $model = News::findOne($id);
            if(!$model){
                throw new NotFoundHttpException('Страница не найдена');
            }
	        $categories = Category::find()->where('parent_id IS NULL')->orderBy(['position' => SORT_ASC])->all();
            return $this->render('page', ['model' => $model, 'categories' => $categories]);
        }
    }

}