<?php


namespace app\controllers;

use yii\web\Controller;
use app\models\User;

class ConfirmController extends Controller
{

    public function actionIndex($key){
        $user = User::findOne(['auth_key' => $key]);
        if($user){
            $user->unconfirmed_email = 1;
            $user->save();
        }
        return $this->redirect('/cabinet');
    }

}