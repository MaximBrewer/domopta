<?php
/**
 * @var $this \yii\web\View
 * @var $model \app\models\ImportForm
 * @var $form \yii\widgets\ActiveForm;
 */
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
$this->registerJsFile('/js/import.js', ['depends' => \yii\web\JqueryAsset::class]);
?>
<div class="row">
    <div class="col-md-3">
        <?php echo $this->render('left_menu', ['category_list' => $category_list, 'searchModel' => $searchModel, 'category' => $category]) ?>
    </div>
    <div class="col-md-9">
        <h2><?php echo $category->name; ?> - Импорт CSV</h2>
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
        <div class="import-link1">
        <label for="file-input-feed" class="file-input">
									<span class='file-input__icon'>
										<svg class="file-input__svg">
											<use xlink:href="/img/sprite-sheet.svg#attach"/>
										</svg>
									</span>
            <span class="file-input__text1">Загрузить файл</span>
        </label>
        </div>
        <?php echo $form->field($model, 'file')->label('')->fileInput(['id' => 'file-input-field']); ?>
        <div class="form-group">
            <?php echo Html::submitButton('Загрузить', ['class' => 'btn btn-success'])?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>

