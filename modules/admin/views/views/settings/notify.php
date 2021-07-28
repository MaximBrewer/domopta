<?php
/**
 * @var $this \yii\web\View
 * @var $model \app\models\Settings;
 * @var $form ActiveForm;
 */

use yii\bootstrap\ActiveForm;
use dosamigos\tinymce\TinyMce;
use yii\bootstrap\Html;

echo $this->render('menu');
?>
<?php $form = ActiveForm::begin(); ?>

<?php echo $form->field($model, 'notify_unactive'); ?>
<?php echo $form->field($model, 'notify_noconfirmed'); ?>

<?php echo $form->field($model, 'notify_product_absend')->widget(TinyMce::class,[
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
<div class="form-group">
    <?php echo Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
</div>
<?php ActiveForm::end(); ?>
