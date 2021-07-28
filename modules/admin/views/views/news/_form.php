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

$this->registerJsFile('/js/news.js', ['depends' => \app\assets\AppAsset::class]);

?>
<?php $form = ActiveForm::begin() ?>
<?php echo $form->field($model, 'name'); ?>
<?php echo $form->field($model, 'slug'); ?>
<?php echo Html::a('Генирировать ссылку', '#', ['id' => 'getLink']); ?>
<?= $form->field($model, 'text')->widget(TinyMce::class, [
    'options' => ['rows' => 50],
    'language' => 'ru',
    'clientOptions' => [
        'height' => '700px',
        //'inline' => true,
        'plugins' => [
            "advlist autolink lists link anchor",
            "searchreplace",
            "media table",
            "image imagetools visualchars textcolor",
            "colorpicker hr nonbreaking"
        ],
        'toolbar1' => "undo redo | styleselect fontselect fontsizeselect forecolor backcolor | bold italic",
        'toolbar2' => "alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | code",
        'image_advtab' => true,

        'images_upload_url'=> Url::toRoute(['/'.MODULE_ID.'/default/upload']),
        // here we add custom filepicker only to Image dialog
        'file_picker_types'=>'image',
        // and here's our custom image picker
        'file_picker_callback'=> new \yii\web\JsExpression("function(callback, value, meta) {
            var input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');

            input.onchange = function() {
                var file = this.files[0];

                var reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = function () {
                    var id = 'blobid' + (new Date()).getTime();
                    var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                    var blobInfo = blobCache.create(id, file, reader.result);
                    blobCache.add(blobInfo);

                    // call the callback and populate the Title field with the file name
                    callback(blobInfo.blobUri(), { title: file.name });
                };
            };
            input.click();
        }")
    ]
]); ?>
<?php echo $form->field($model, 'title'); ?>
<?php //echo $form->field($model, 'keywords'); ?>
<?php echo $form->field($model, 'description'); ?>
<?php echo Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
<?php ActiveForm::end(); ?>
