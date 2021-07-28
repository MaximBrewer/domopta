<?php
/**
 * Created by PhpStorm.
 * User: resh
 * Date: 25.01.19
 * Time: 18:30
 */

namespace app\modules\admin\controllers;


use app\models\SendForm;
use yii\web\Controller;

class SendController extends Controller {

	public function actionIndex(){
		$model = new SendForm();
		if($model->load(\Yii::$app->request->post()) && $model->validate()){
			$model->process();
			return $this->refresh();
		}
		return $this->render('index', ['model' => $model]);
	}

}