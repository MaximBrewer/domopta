<?php
/**
 * @var $this \yii\web\View
 * @var $model \app\models\Settings;
 * @var $form ActiveForm;
 */

use yii\bootstrap\ActiveForm;
use dosamigos\tinymce\TinyMce;
use yii\bootstrap\Html;

echo $this->render('menu');
?>
<?php $form = ActiveForm::begin(); ?>
<?php echo $form->field($model, 'adminEmail') ?>
<?php echo $form->field($model, 'sellEmail') ?>
<?php echo $form->field($model, 'phone_call') ?>
<?php echo $form->field($model, 'phone_order') ?>
<?php echo $form->field($model, 'phone_admin') ?>
<div class="form-group">
    <?php echo Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
</div>
<?php ActiveForm::end(); ?>
