<?php
/**
 * @var $this \yii\web\View
 * @var $model \app\models\Category
 * @var $form \yii\widgets\ActiveForm
 */
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use yii\bootstrap\Tabs;
use dosamigos\tinymce\TinyMce;

$this->registerJsFile('/js/category.js', ['depends' => \app\assets\AppAsset::className()]);

?>
<h2><?php echo $model->isNewRecord?'Добавить':'Редактировать'; ?> категорию</h2>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
<?php $this->beginBlock('main'); ?>
<?php echo $form->field($model, 'parent_id')->label(false)->hiddenInput(); ?>
<?php echo $form->field($model, 'id')->label(false)->hiddenInput(); ?>
<?php echo $form->field($model, 'name'); ?>
<?php echo $form->field($model, 'slug'); ?>
<?php echo Html::a('Генирировать ссылку', '#', ['id' => 'getLink']); ?>
<?php echo $form->field($model, 'country'); ?>
<?php echo $form->field($model, 'certificate'); ?>
<?php echo Html::img($model->getThumbUploadUrl('image')); ?>
<?php echo $form->field($model, 'image')->fileInput(['accept' => 'image/*']); ?>
<?php echo $form->field($model, 'rec_cat_id')->widget(\kartik\select2\Select2::className(), [
        'data' => \yii\helpers\ArrayHelper::map(\app\models\Category::find()->orderBy(['name' => SORT_ASC])->all(), 'id', 'name'),
        'options' => ['placeholder' => 'Выберите категорию ...'],
        'pluginOptions' => [
	        'allowClear' => true
        ],
]) ?>
<?php $this->endBlock(); ?>

<?php $this->beginBlock('meta'); ?>
<?php echo $form->field($model, 'title'); ?>
<?php //echo $form->field($model, 'keywords'); ?>
<?php echo $form->field($model, 'description'); ?>
<?php $this->endBlock(); ?>


<?php $this->beginBlock('text'); ?>
<?php echo $form->field($model, 'text')->widget(TinyMce::className(),[
    'options' => ['rows' => 6],
    'language' => 'ru',
    'clientOptions' => Yii::$app->params['clientOptions']
]); ?>
<?php echo $form->field($model, 'additional_text')->widget(TinyMce::className(),[
    'options' => ['rows' => 6],
    'language' => 'ru',
    'clientOptions' => Yii::$app->params['clientOptions']
]); ?>
<?php $this->endBlock(); ?>


<?php echo Tabs::widget(['items'=>[
    [
        'label' => 'Основное',
        'content' => $this->blocks['main']
    ],
    [
        'label' => 'Мета',
        'content' => $this->blocks['meta']
    ],
    [
        'label' => 'Текст',
        'content' => $this->blocks['text']
    ]
]]) ?>
<div class="form-group">
    <?php echo Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
</div>
<?php ActiveForm::end() ?>
