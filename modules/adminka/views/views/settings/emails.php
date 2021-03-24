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
<?php echo $form->field($model, 'email_active')->widget(TinyMce::className(),[
    'options' => ['rows' => 6],
    'language' => 'ru',
    'clientOptions' => [
        'height' => '500px',
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

        'images_upload_url'=> Url::toRoute(['/adminka/default/upload']),
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

<?php echo $form->field($model, 'email_success')->widget(TinyMce::className(),[
    'options' => ['rows' => 6],
    'language' => 'ru',
    'clientOptions' => [
        'height' => '500px',
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

        'images_upload_url'=> Url::toRoute(['/adminka/default/upload']),
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
<p>{%link%} {%password%}</p>
<?php echo $form->field($model, 'email_block')->widget(TinyMce::className(),[
    'options' => ['rows' => 6],
    'language' => 'ru',
    'clientOptions' => [
        'height' => '500px',
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

        'images_upload_url'=> Url::toRoute(['/adminka/default/upload']),
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
<p>{%comment%}</p>
<?php echo $form->field($model, 'email_order')->widget(TinyMce::className(),[
    'options' => ['rows' => 6],
    'language' => 'ru',
    'clientOptions' => [
        'height' => '500px',
        'plugins' => [
            "advlist autolink lists link charmap print preview anchor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime media table contextmenu paste "
        ],
        'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | code"
    ]
]); ?>

<?php echo $form->field($model, 'email_unblock')->widget(TinyMce::className(),[
    'options' => ['rows' => 6],
    'language' => 'ru',
    'clientOptions' => [
        'height' => '500px',
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

        'images_upload_url'=> Url::toRoute(['/adminka/default/upload']),
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

<?php echo $form->field($model, 'email_delete')->widget(TinyMce::className(),[
    'options' => ['rows' => 6],
    'language' => 'ru',
    'clientOptions' => [
        'height' => '500px',
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

        'images_upload_url'=> Url::toRoute(['/adminka/default/upload']),
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

<?php echo $form->field($model, 'email_confirm')->widget(TinyMce::className(),[
    'options' => ['rows' => 6],
    'language' => 'ru',
    'clientOptions' => [
        'height' => '500px',
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

        'images_upload_url'=> Url::toRoute(['/adminka/default/upload']),
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
<div class="form-group">
    <?php echo Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
</div>
<?php ActiveForm::end(); ?>
