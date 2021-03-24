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

<?php echo $form->field($model, 'notify_product_absend')->widget(TinyMce::className(),[
    'options' => ['rows' => 6],
    'language' => 'ru',
    'clientOptions' => Yii::$app->params['clientOptions']
]); ?>
<div class="form-group">
    <?php echo Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
</div>
<?php ActiveForm::end(); ?>
