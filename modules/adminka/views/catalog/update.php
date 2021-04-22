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
$prev = $model->getPrevproduct() ? $model->getPrevproduct() : $model;
$next = $model->getNextproduct() ? $model->getNextproduct() : $model;
?>
<div class="row">
    <div class="col-md-3">
        <?php echo $this->render('left_menu', ['category_list' => $category_list, 'searchModel' => $searchModel, 'category' => $category]) ?>
    </div>
    <div class="col-md-9">
        <div class="form-group form-group-product">
            <div class="row">
                <div class="col-lg-12" style="margin-bottom:10px;">
                    <a href="/adminka/catalog/index?id=<?php echo $model->category_id ?>" class="btn btn-success">Назад в категорию</a>
                    <a href="/adminka/catalog/update?id=<?php echo $prev->id ?>" class="btn btn-success" <?php echo $prev->id == $model->id ? 'disabled="disabled"' : '' ?>>&lt; Предыдущий товар</a>
                    <a href="/adminka/catalog/update?id=<?php echo $next->id ?>" class="btn btn-success" <?php echo $next->id == $model->id ? 'disabled="disabled"' : '' ?>>Следующий товар &gt;</a>
                </div>
                <div class="col-lg-6">
                    <?php $form = \yii\widgets\ActiveForm::begin(['method' => 'get', 'action' => 'index']) ?>
                    <div class="input-group">
                        <?php echo Html::textInput($searchModel->formName() . '[text]', $searchModel->text, ['class' => 'form-control']) ?>
                        <span class="input-group-addon">
                            <?php echo Html::submitInput('Искать', ['class' => 'btn btn-success search-class2']) ?>
                        </span>
                    </div>
                    <?php echo Html::radioList($searchModel->formName() . '[text_type]', $searchModel->text_type ? $searchModel->text_type : 1, [1 => 'Каталог', 0 => 'Текущая категория']) ?>
                    <?php \yii\widgets\ActiveForm::end(); ?>
                </div>
            </div>
        </div>
        <div class="product-link pull-right"><?php echo Html::a('Ссылка на товар', $model->slug, ['target' => '_blank', 'title' => $model->slug]) ?></div>
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

        <?php $this->beginBlock('main'); ?>
        <div style="display: none">
            <?php echo $form->field($model, 'slug')->textInput(['readonly' => Yii::$app->user->identity->role != 'admin']); ?>
            <?php if (Yii::$app->user->identity->role == 'admin') : ?>
                <?php echo Html::a('Генирировать ссылку', '#', ['id' => 'getLink']); ?>
            <?php endif; ?>
        </div>
        <?php echo $form->field($model, 'id')->label(false)->hiddenInput(); ?>
        <?php echo $form->field($model, 'article')->textInput(['readonly' => true]); ?>
        <?php echo $form->field($model, 'article_index')->textInput(['readonly' => true]); ?>
        <?php echo $form->field($model, 'name')->textInput(['readonly' => true]); ?>
        <?php echo $form->field($model, 'color')->textInput(['readonly' => Yii::$app->user->identity->role != 'admin', 'style' => 'color: #000; font-weight: bold; background: #fff;']); ?>
        <?php echo $form->field($model, 'price')->textInput(['readonly' => true]); ?>
        <?php echo $form->field($model, 'price2')->textInput(['readonly' => true]); ?>
        <?php echo $form->field($model, 'pack_quantity')->textInput(['readonly' => true]); ?>
        <?php echo $form->field($model, 'size')->textInput(['readonly' => true]); ?>
        <?php echo $form->field($model, 'tradekmark')->textInput(['readonly' => true]); ?>
        <?php echo $form->field($model, 'consist')->textInput(['readonly' => true]); ?>
        <?php echo $form->field($model, 'ooo')->checkbox(['readonly' => true, 'disabled' => true]); ?>
        <?php echo $form->field($model, 'flag')->label('Есть на остатке')->checkbox(); ?>
        <?php $this->endBlock(); ?>

        <?php $this->beginBlock('photo'); ?>
        <div class="form-group">
            <div class="row">
                <div class="col-md-6"><?php echo $form->field($model, 'article')->textInput(['readonly' => true]); ?></div>
                <div class="col-md-6">
                    <div class="form-group field-products-color">
                        <label class="control-label" for="products-color">Цвета</label>
                        <div class="form-control" disabled="true"><?php echo $model->color;?></div>

                        <p class="help-block help-block-error"></p>
                    </div>
                </div>
            </div>
            <br />
            <?php echo Html::submitButton('Сохранить', ['class' => 'btn btn-success', "style" => "float:right;"]); ?>
            <?php echo Html::a('Удалить все фото', '#', ['class' => 'btn btn-danger', 'data-toggle' => 'modal', 'data-target' => '#delete-photo-modal']); ?>
        </div>

        <?php
        $items = [];
        $config = [];
        foreach ($model->pictures as $image) :
            $items[] = Html::img($image->getUrl('big', $image->order), ['class' => 'kv-preview-data krajee-init-preview file-preview-image']);
            $config[] = [
                'type' => 'image',
                'key' => $image->id,
                'url' => Url::to(['deleteimage', 'id' => $image->id]),
            ];
        endforeach; ?>

        <?php
        echo $form->field($model, 'images[]')->widget(\app\components\fileinput\Fileinput::className(), []);
        ?>
        <?php $this->endBlock(); ?>

        <?php $this->beginBlock('text'); ?>
        <?php echo $form->field($model, 'description')->widget(TinyMce::className(), [
            'options' => [],
            'language' => 'ru',
            'clientOptions' => [
                'readonly' => Yii::$app->user->identity->role != 'admin' && Yii::$app->user->identity->role != 'contentmanager',
                'height' => '700px',
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

                'images_upload_url' => Url::toRoute(['/adminka/default/upload']),
                // here we add custom filepicker only to Image dialog
                'file_picker_types' => 'image',
                // and here's our custom image picker
                'file_picker_callback' => new \yii\web\JsExpression("function(callback, value, meta) {
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


        <?php echo Tabs::widget(['items' => [
            [
                'label' => 'Основные свойства',
                'content' => $this->blocks['main']
            ],
            [
                'label' => 'Фото',
                'content' => $this->blocks['photo']
            ],
            Yii::$app->user->identity->role == 'moderator' ? ([
                'label' => '',

            ]) : [
                'label' => 'Описание',
                'content' => $this->blocks['text'],
            ],
        ]]) ?>
        <div class="form-group">
            <?php echo Html::submitButton('Сохранить', ['class' => 'btn btn-success']); ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
<?php Modal::begin([
    'id' => 'delete-photo-modal',
    'header' => 'Удалить все фото'
]) ?>
<p>Вы действительно хотите удалить все фото?</p>
<div class="form-group">
    <?php echo Html::a('Отмена', '#', ['class' => 'btn btn-default', 'data-dismiss' => 'modal']); ?>
    <?php echo Html::a('Удалить', '#', ['class' => 'btn btn-success', 'data-dismiss' => 'modal', 'data-toggle' => 'modal', 'data-target' => '#confirm-modal']); ?>
</div>
<?php Modal::end(); ?>

<?php Modal::begin([
    'id' => 'confirm-modal',
    'header' => 'Удалить все фото'
]) ?>
<p>Подтвердите удаление?</p>
<div class="form-group">
    <?php echo Html::a('Отмена', '#', ['class' => 'btn btn-default', 'data-dismiss' => 'modal']); ?>
    <?php echo Html::a('Удалить', ['deleteproductphotos', 'id' => $model->id], ['class' => 'btn btn-success']); ?>
</div>
<?php Modal::end(); ?>