<?php
/* @var $this \yii\web\View */
/* @var $model \app\models\Vk|null|static */
/* @var $form \yii\widgets\ActiveForm */
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>
<?php $form = ActiveForm::begin(); ?>
<?php echo $form->field($model, 'vk_http') ?>
<?php echo $form->field($model, 'vk_active')->checkbox() ?>
<div>
	<?php echo Html::submitInput('Сохранить'); ?>
</div>
<?php ActiveForm::end(); ?>


