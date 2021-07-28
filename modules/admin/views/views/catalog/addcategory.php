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

$this->registerJsFile('/js/category.js', ['depends' => \app\assets\AppAsset::class]);

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
<?php $this->endBlock(); ?>

<?php $this->beginBlock('meta'); ?>
<?php echo $form->field($model, 'title'); ?>
<?php //echo $form->field($model, 'keywords'); ?>
<?php echo $form->field($model, 'description'); ?>
<?php $this->endBlock(); ?>


<?php $this->beginBlock('text'); ?>
<?php echo $form->field($model, 'text')->widget(TinyMce::class,[
    'options' => ['rows' => 6],
    'language' => 'ru',
    'clientOptions' => [
        'height' => '700px',
        'plugins' => [
            "advlist autolink lists link charmap print preview anchor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime media table contextmenu paste "
        ],
        'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | code"
    ]
]); ?>
<?php echo $form->field($model, 'additional_text')->widget(TinyMce::class,[
    'options' => ['rows' => 6],
    'language' => 'ru',
    'clientOptions' => [
        'height' => '700px',
        'plugins' => [
            "advlist autolink lists link charmap print preview anchor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime media table contextmenu paste "
        ],
        'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | code"
    ]
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
