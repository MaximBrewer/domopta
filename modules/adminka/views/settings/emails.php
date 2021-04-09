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
<div class="container">
<?php $form = ActiveForm::begin(); ?>
<?php echo $form->field($model, 'email_active')->widget(TinyMce::className(),[
    'options' => ['rows' => 6],
    'language' => 'ru',
    'clientOptions' => Yii::$app->params['clientOptions']
]); ?>

<?php
//echo $form->field($model, 'email_success')->widget(TinyMce::className(),[
//    'options' => ['rows' => 6],
//    'language' => 'ru',
//    'clientOptions' => Yii::$app->params['clientOptions']
//]);
?>
<!--<p>{%link%} {%password%}</p>-->
<?php echo $form->field($model, 'email_block')->widget(TinyMce::className(),[
    'options' => ['rows' => 6],
    'language' => 'ru',
    'clientOptions' => Yii::$app->params['clientOptions']
]); ?>
<p>{%comment%}</p>
<?php echo $form->field($model, 'email_order')->widget(TinyMce::className(),[
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

<?php echo $form->field($model, 'email_unblock')->widget(TinyMce::className(),[
    'options' => ['rows' => 6],
    'language' => 'ru',
    'clientOptions' => Yii::$app->params['clientOptions']
]); ?>

<?php echo $form->field($model, 'email_delete')->widget(TinyMce::className(),[
    'options' => ['rows' => 6],
    'language' => 'ru',
    'clientOptions' => Yii::$app->params['clientOptions']
]); ?>

<?php
echo $form->field($model, 'email_confirm')->widget(TinyMce::className(),[
    'options' => ['rows' => 6],
    'language' => 'ru',
    'clientOptions' => Yii::$app->params['clientOptions']
]);
?>
<div class="form-group">
    <?php echo Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
</div>
<?php ActiveForm::end(); ?>
</div>