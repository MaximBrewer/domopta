<?php
/**
 * Created by PhpStorm.
 * User: resh
 * Date: 11.05.17
 * Time: 17:30
 */

namespace app\widgets\loginform;

use yii\base\Widget;
use app\models\LoginForm as Form;

class LoginForm extends Widget
{
    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $model = \Yii::createObject(Form::className());
        echo $this->render('login', ['model' => $model]);
    }

}