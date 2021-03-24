<?php
/**
 * @var $this \yii\web\View
 * @var $model \app\models\News
 * @var $form \yii\bootstrap\ActiveForm
 */
use yii\widgets\ActiveForm;
use yii\bootstrap\Html;
use dosamigos\tinymce\TinyMce;
use yii\helpers\Url;

$this->registerJsFile('/js/news.js', ['depends' => \app\assets\AppAsset::className()]);

?>
<?php $form = ActiveForm::begin() ?>
<?php echo $form->field($model, 'name'); ?>
<?php echo $form->field($model, 'slug'); ?>
<?php echo Html::a('Генирировать ссылку', '#', ['id' => 'getLink']); ?>
<?= $form->field($model, 'text')->widget(TinyMce::className(), [
    'options' => ['rows' => 50],
    'language' => 'ru',
    'clientOptions' => Yii::$app->params['clientOptions']
]); ?>
<?php echo $form->field($model, 'title'); ?>
<?php //echo $form->field($model, 'keywords'); ?>
<?php echo $form->field($model, 'description'); ?>
<?php echo Html::img($model->getThumbUploadUrl('image')); ?>
<?php echo $form->field($model, 'image')->fileInput(['accept' => 'image/*']); ?>
<?php echo Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
<?php ActiveForm::end(); ?>
