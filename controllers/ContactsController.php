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
		return $this->render('index');
	}

}