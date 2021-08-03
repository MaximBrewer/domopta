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

$clientOptions = Yii::$app->params['clientOptions'];
$clientOptions['images_upload_url'] = Url::toRoute(['/' . MODULE_ID . '/default/upload']);
?>
<div class="container">
    <?php echo $this->render('../_alert', ['module' => \Yii::$app->getModule('user')]); ?>
</div>
<?php echo $this->render('menu'); ?>
<div class="container">
    <?php $form = ActiveForm::begin(); ?>
    <?php echo $form->field($model, 'contacts')->widget(TinyMce::class, [
        'options' => ['rows' => 6],
        'language' => 'ru',
        'clientOptions' => 	$clientOptions
    ]); ?>
    <div class="form-group">
        <?php echo Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>