<?php
/**
 * Created by PhpStorm.
 * User: resh
 * Date: 08.05.17
 * Time: 15:36
 */

namespace app\modules\admin\controllers;

use app\models\Page;
use app\models\PageSearch;
use yii\behaviors\SluggableBehavior;
use app\helpers\Inflector;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use dektrium\user\filters\AccessRule;
use yii\filters\AccessControl;

class PagesController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'ruleConfig' => [
                    'class' => AccessRule::class,
                ],
                'rules' => [
                    [
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return \Yii::$app->user->identity->role == 'admin';
                        }
                    ],
                ],
            ],
        ];
    }

    public function actionIndex(){
        $searchModel = new PageSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        return $this->render('index', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider]);
    }

    public function actionAdd(){
        $model = new Page();
        $model->status = 1;
        if($model->load(\Yii::$app->request->post()) && $model->save()){
            return $this->redirect('index');
        }
        return $this->render('add', ['model' => $model]);
    }

    public function actionUpdate($id){
        $model = Page::findOne($id);
        if(!$model){
            throw new NotFoundHttpException('Страница не найдена');
        }
        if($model->load(\Yii::$app->request->post()) && $model->save()){
            return $this->redirect('index');
        }
        return $this->render('update', ['model' => $model]);
    }

    public function actionSlug($string){
        return '/' . Inflector::slug($string);
    }

    public function actionDelete($id){
        $model = Page::findOne($id);
        $model->delete();
        return $this->redirect(['index']);
    }

}