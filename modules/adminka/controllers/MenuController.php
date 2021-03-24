<?php
/**
 * Created by PhpStorm.
 * User: resh
 * Date: 12.05.17
 * Time: 10:31
 */

namespace app\modules\adminka\controllers;

use app\models\Menu;
use app\models\MenuSearch;
use yii\web\Controller;
use dektrium\user\filters\AccessRule;
use yii\filters\AccessControl;

class MenuController extends Controller
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
                ],
            ],
        ];
    }

    public function actionIndex(){
        $searchModel = new MenuSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        $model = new Menu();
        if($model->load(\Yii::$app->request->post()) && $model->save()){
            $this->refresh();
        }
        return $this->render('index', ['dataProvider' => $dataProvider, 'model' => $model]);
    }

    public function actionDelete($id){
        $model = Menu::findOne($id);
        $model->delete();
        return $this->redirect(['index']);
    }

}