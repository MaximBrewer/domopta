<?php
/**
 * @var $this \yii\web\View
 * @var $model \app\models\ImportForm
 * @var $form \yii\widgets\ActiveForm;
 */
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>
<div class="row">
    <div class="col-md-3">
        <?php echo $this->render('left_menu', ['category_list' => $category_list, 'searchModel' => $searchModel, 'category' => $category]) ?>
    </div>
    <div class="col-md-9">
        <h2>Импортровать из CSV</h2>
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
        <?php echo $form->field($model, 'file')->fileInput(); ?>
        <div class="form-group">
            <?php echo Html::submitButton('Загрузить', ['class' => 'btn btn-success'])?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>

