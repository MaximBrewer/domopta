<?php

/**
 * @var $this \yii\web\View
 * @var $model \app\models\Settings;
 * @var $form ActiveForm;
 */

use yii\bootstrap\ActiveForm;
use dosamigos\tinymce\TinyMce;
use yii\bootstrap\Html;
?>
<div class="container">
    <?php echo $this->render('../_alert', ['module' => \Yii::$app->getModule('user')]); ?>
</div>
<?php echo $this->render('menu'); ?>
<div class="container">
    <?php $form = ActiveForm::begin(); ?>
    <?php echo $form->field($model, 'hint1') ?>
    <?php echo $form->field($model, 'hint2') ?>
    <?php echo $form->field($model, 'hint3') ?>
    <div class="form-group">
        <?php echo Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>