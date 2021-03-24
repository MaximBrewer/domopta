<?php
/**
 * Created by PhpStorm.
 * User: resh
 * Date: 10.05.17
 * Time: 12:00
 */

namespace app\controllers;

use yii\web\Controller;

class PagesController extends Controller
{

    public function actionIndex(){
        return $this->render('index');
    }

}