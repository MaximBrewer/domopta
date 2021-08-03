<?php
/* @var $this \yii\web\View */
/* @var $model \app\models\SendForm */
/* @var $form \yii\widgets\ActiveForm */

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use dosamigos\tinymce\TinyMce;
?>
<div class="container">
	<?php echo $this->render('../_alert', ['module' => \Yii::$app->getModule('user')]); ?>
	<?php $form = ActiveForm::begin(['method' => 'post', 'options' => ['enctype' => 'multipart/form-data']]) ?>
	<?php echo $form->field($model, 'text')->textarea() ?>

	<?php
	// $clientOptions = Yii::$app->params['clientOptions'];
	// $clientOptions['images_upload_url'] = Url::toRoute(['/'.MODULE_ID.'/default/upload']);
	//echo $form->field($model, 'text')->widget(TinyMce::class,[
	//	'options' => ['rows' => 6],
	//	'language' => 'ru',
	//	'clientOptions' => $clientOptions
	//])
	?>

	<?php echo $form->field($model, 'file')->fileInput(); ?>
	<div class="form-group">
		<?php echo Html::submitInput('Отправить', ['class' => 'btn btn-success']) ?>
	</div>
	<?php ActiveForm::end() ?>

</div>