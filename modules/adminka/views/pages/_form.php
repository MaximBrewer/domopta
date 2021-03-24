<?php
/**
 * @var $this \yii\web\View
 * @var $model \app\models\Page
 * @var $form \yii\bootstrap\ActiveForm
 */
use yii\widgets\ActiveForm;
use yii\bootstrap\Html;
use dosamigos\tinymce\TinyMce;
use yii\helpers\Url;

$this->registerJsFile('/js/page.js', ['depends' => \app\assets\AppAsset::className()]);

?>
<?php $form = ActiveForm::begin() ?>
<?php echo $form->field($model, 'name'); ?>
<?php echo $form->field($model, 'slug'); ?>
<?php echo Html::a('Генирировать ссылку', '#', ['id' => 'getLink']); ?>
<?php echo $form->field($model, 'text')->widget(TinyMce::className(),[
    'options' => ['rows' => 20],
    'language' => 'ru',
    'clientOptions' => Yii::$app->params['clientOptions']
]); ?>
<?php echo $form->field($model, 'additional_text')->widget(TinyMce::className(),[
    'options' => ['rows' => 20],
    'language' => 'ru',
    'clientOptions' => Yii::$app->params['clientOptions']
]); ?>
<?php echo $form->field($model, 'title'); ?>
<?php echo $form->field($model, 'description'); ?>
<?php //echo $form->field($model, 'keywords'); ?>
<?php echo $form->field($model, 'status')->checkbox(); ?>
<?php echo Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
<?php ActiveForm::end(); ?>
