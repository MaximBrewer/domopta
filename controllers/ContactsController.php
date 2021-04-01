<?php
/**
 * Created by PhpStorm.
 * User: resh
 * Date: 24.01.19
 * Time: 17:11
 */

namespace app\controllers;


use yii\web\Controller;

class ContactsController extends Controller {

	public function actionIndex(){

		\Yii::$app->params['page'] = new \app\models\Page();
		\Yii::$app->params['page']->title = "Контакты | Оптовый Комплекс \"Легкий Ветер\"";
		\Yii::$app->params['page']->keywords = "Контакты | Оптовый Комплекс \"Легкий Ветер\"";
		\Yii::$app->params['page']->description = "Контакты | Оптовый Комплекс \"Легкий Ветер\"";

		return $this->render('index');
	}

}