<?php
/* @var $this \yii\web\View */
/* @var $model \app\models\SendForm */
/* @var $form \yii\widgets\ActiveForm */
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use dosamigos\tinymce\TinyMce;
?>
<?php $form = ActiveForm::begin(['method' => 'post', 'options' => ['enctype' => 'multipart/form-data']]) ?>
<?php echo $form->field($model, 'text')->textarea()?>

<?php
//echo $form->field($model, 'text')->widget(TinyMce::className(),[
//	'options' => ['rows' => 6],
//	'language' => 'ru',
//	'clientOptions' => Yii::$app->params['clientOptions']
//])
?>

<?php echo $form->field($model, 'file')->fileInput(); ?>
<div class="form-group">
	<?php echo Html::submitInput('Отправить', ['class' => 'btn btn-success']) ?>
</div>
<?php ActiveForm::end() ?>
