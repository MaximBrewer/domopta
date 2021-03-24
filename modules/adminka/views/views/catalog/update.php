<?php
/**
 * @var $model \app\models\Products
 * @var $form \yii\bootstrap\ActiveForm
 * @var $this \yii\web\View
 */
use yii\bootstrap\Tabs;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use kartik\sortable\Sortable;
use yii\helpers\Url;
use dosamigos\tinymce\TinyMce;
use yii\bootstrap\Modal;

$this->registerJsFile('/js/product.js', ['depends' => \app\assets\AdminAsset::className()]);
?>ывамивапм
<div class="product-link pull-right"><strong>Ссылка на товар:</strong> <?php echo Html::a($model->slug, $model->slug, ['target' => '_blank']) ?></div>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
<div class="form-group">
    <?php echo Html::submitButton('Сохранить', ['class' => 'btn btn-success']); ?>
</div>
<?php $this->beginBlock('main'); ?>
<?php echo $form->field($model, 'slug')->textInput(['readonly' => Yii::$app->user->identity->role != 'admin']); ?>
<?php if(Yii::$app->user->identity->role == 'admin'): ?>
<?php echo Html::a('Генирировать ссылку', '#', ['id' => 'getLink']); ?>
<?php endif; ?>
<?php echo $form->field($model, 'id')->label(false)->hiddenInput(); ?>
<?php echo $form->field($model, 'article')->textInput(['readonly' => true]); ?>
<?php echo $form->field($model, 'article_index')->textInput(['readonly' => true]); ?>
<?php echo $form->field($model, 'name')->textInput(['readonly' => true]); ?>
<?php echo $form->field($model, 'price')->textInput(['readonly' => true]); ?>
<?php echo $form->field($model, 'color')->textInput(['readonly' => Yii::$app->user->identity->role != 'admin']); ?>
<?php echo $form->field($model, 'pack_quantity')->textInput(['readonly' => true]); ?>
<?php echo $form->field($model, 'size')->textInput(['readonly' => true]); ?>
<?php echo $form->field($model, 'tradekmark')->textInput(['readonly' => true]); ?>
<?php echo $form->field($model, 'consist')->textInput(['readonly' => true]); ?>
<?php echo $form->field($model, 'ooo')->checkbox(['readonly' => true, 'disabled' => true]); ?>
<?php $this->endBlock(); ?>

<?php $this->beginBlock('photo'); ?>
<div class="form-group">
    <br />
    <?php echo Html::a('Удалить все фото', '#', ['class' => 'btn btn-danger', 'data-toggle' => 'modal', 'data-target' => '#delete-photo-modal']); ?>
</div>

<?php
$items = [];
$config = [];
foreach ($model->pictures as $image):
     $items[] = Html::img($image->getUrl('small', $image->order), ['class' => 'kv-preview-data krajee-init-preview file-preview-image']);
     $config[] = [
             'type' => 'image',
             'key' => $image->id,
             'url' => Url::to(['deleteimage', 'id' => $image->id]),
     ];
endforeach; ?>

<?php echo $form->field($model, 'images[]')->widget(\kartik\file\FileInput::className(), [
    'options' => ['accept' => 'image/*', 'multiple' => true],
    'pluginOptions' => [
        'browseClass' => 'btn btn-success',
        'uploadClass' => 'btn btn-info',
        'removeClass' => 'btn btn-danger',
        'removeIcon' => '<i class="glyphicon glyphicon-trash"></i> ',
        'initialPreview' => $items,
        'initialPreviewAsData' => false,
        'overwriteInitial' => false,
        'initialPreviewFileType' => 'image',
        'initialPreviewConfig' => $config,
        'purifyHtml' => true,
        'uploadUrl' => Url::to(['upload', 'id' => $model->id])
    ],
    'pluginEvents' => [
            'filesorted' => 'sort'
    ]
]); ?>
<?php $this->endBlock(); ?>

<?php $this->beginBlock('text'); ?>
<?php echo $form->field($model, 'description')->widget(TinyMce::className(),[
    'options' => ['rows' => 20],
    'language' => 'ru',
    'clientOptions' => [
        'height' => '700px',
        'readonly' => Yii::$app->user->identity->role != 'admin',
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
<?php $this->endBlock(); ?>


<?php echo Tabs::widget(['items'=>[
    [
        'label' => 'Основные свойства',
        'content' => $this->blocks['main']
    ],
    [
        'label' => 'Фото',
        'content' => $this->blocks['photo']
    ],
    [
        'label' => 'Описание',
        'content' => $this->blocks['text']
    ]
]]) ?>
<div class="form-group">
    <?php echo Html::submitButton('Сохранить', ['class' => 'btn btn-success']); ?>
</div>
<?php ActiveForm::end(); ?>
<?php Modal::begin([
    'id' => 'delete-photo-modal',
    'header' => 'Удалить все фото'
]) ?>
    <p>Вы действительно хотите удалить все фото?</p>
    <div class="form-group">
        <?php echo Html::a('Отмена', '#',['class' => 'btn btn-default', 'data-dismiss' => 'modal']); ?>
        <?php echo Html::a('Удалить', '#', ['class' => 'btn btn-success', 'data-dismiss' => 'modal', 'data-toggle' => 'modal', 'data-target' => '#confirm-modal']); ?>
    </div>
<?php Modal::end(); ?>

<?php Modal::begin([
    'id' => 'confirm-modal',
    'header' => 'Удалить все фото'
]) ?>
    <p>Подтвердите удаление?</p>
    <div class="form-group">
        <?php echo Html::a('Отмена', '#',['class' => 'btn btn-default', 'data-dismiss' => 'modal']); ?>
        <?php echo Html::a('Удалить', ['deleteproductphotos', 'id' => $model->id], ['class' => 'btn btn-success']); ?>
    </div>
<?php Modal::end(); ?>