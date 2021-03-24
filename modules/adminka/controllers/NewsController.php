<?php
/**
 * Created by PhpStorm.
 * User: resh
 * Date: 11.05.17
 * Time: 12:23
 */

namespace app\modules\adminka\controllers;

use app\models\News;
use app\models\NewsSearch;
use yii\helpers\Inflector;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use dektrium\user\filters\AccessRule;
use yii\filters\AccessControl;

class NewsController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'ruleConfig' => [
                    'class' => AccessRule::className(),
                ],
                'rules' => [
                    [
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return \Yii::$app->user->identity->role == 'admin';
                        }
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index', 'add', 'update', 'slug'],
                        'matchCallback' => function ($rule, $action) {
                            return \Yii::$app->user->identity->role == 'contentmanager';
                        }
                    ],
                ],
            ],
        ];
    }

    public function actionIndex(){
        $searchModel = new NewsSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        return $this->render('index', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider]);
    }

    public function actionAdd(){
        $model = new News();
        if($model->load(\Yii::$app->request->post()) && $model->save()){
            return $this->redirect(['index']);
        }
        return $this->render('add', ['model' => $model]);
    }

    public function actionUpdate($id){
        $model = News::findOne($id);
        if(!$model){
            throw new NotFoundHttpException('Страница не найдена');
        }
        if($model->load(\Yii::$app->request->post()) && $model->save()){
            return $this->redirect(['index']);
        }
        return $this->render('update', ['model' => $model]);
    }

    public function actionDelete($id){
        $model = News::findOne($id);
        $model->delete();
        return $this->redirect(['index']);
    }

    public function actionSlug($string){
        $slug =  '/news/' . Inflector::slug($string, '-');
        $iteration = 0;
        while(News::findOne(['slug' => $slug])){
            $iteration++;
            $slug = '/news/' . Inflector::slug($string, '-') . '-' . $iteration;
        }
        return $slug;
    }

}