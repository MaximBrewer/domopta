<?php
/**
 * Created by PhpStorm.
 * User: resh
 * Date: 02.05.17
 * Time: 16:55
 */

namespace app\modules\manager\controllers;

use yii\web\Controller;
use yii\web\UploadedFile;

class DefaultController extends Controller
{

    public function beforeAction($action)
    {
        if($action->id == 'upload'){
            \Yii::$app->request->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }

    public function actionIndex(){
        if(\Yii::$app->user->identity->role == 'manager'){
            return $this->redirect(['/'.MODULE_ID.'/orders']);
        } else {
            return $this->redirect(['/'.MODULE_ID.'/catalog']);
        }
    }

    public function actionUpload(){
        $file = UploadedFile::getInstanceByName('file');
        $fname = uniqid() . '.' . $file->extension;
        $path = \Yii::getAlias('@webroot/upload/images/');
        @mkdir($path);
        $file->saveAs($path . $fname);
        return json_encode(['location' => '/upload/images/' . $fname]);
    }

}