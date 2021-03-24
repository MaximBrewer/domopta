<?php

use yii\helpers\Html;

$form = \yii\widgets\ActiveForm::begin(['options' => [
    'enctype' => 'multipart/form-data',
    'action' => '/adminka/test/upload',
    'method' => 'post',
    'id' => 'upload-form'
]]);
echo $form->field($model, 'images[]')->widget(\app\components\fileinput\Fileinput::className(), []);
\yii\widgets\ActiveForm::end();
