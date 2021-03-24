<?php

/**
 * @var $this \yii\web\View
 * @var $model \app\models\Settings;
 * @var $form ActiveForm;
 */

use yii\bootstrap\ActiveForm;
use dosamigos\tinymce\TinyMce;
use yii\bootstrap\Html;
use yii\helpers\Url;

echo $this->render('menu');

?>
<?php $form = ActiveForm::begin(); ?>
<?php echo $form->field($model, 'smtpHost') ?>
<?php echo $form->field($model, 'smtpEmail') ?>
<?php echo $form->field($model, 'smtpPassword') ?>
<?php echo $form->field($model, 'smtpPort') ?>
<?php echo $form->field($model, 'smtpEncryption') ?>
<?php echo $form->field($model, 'smtpStreamOptionsSslVerifyPeer')->checkbox(['value' => 1, 'checked' => !!$model->smtpStreamOptionsSslVerifyPeer]) ?>
<?php echo $form->field($model, 'smtpStreamOptionsSslAllowSelfSigned')->checkbox(['value' => 1, 'checked' => !!$model->smtpStreamOptionsSslAllowSelfSigned]) ?>

<div class="form-group">
    <?php echo Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
</div>
<?php ActiveForm::end(); ?>