<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use app\widgets\MyActiveField;

$this->registerJsFile('/js/contact.js', ['depends' => \yii\web\JqueryAsset::className()]);
if($model->hasErrors()){
    $str = '';
    foreach ($model->getErrors() as $error){
        $str .= $error[0] . "\\n";
    }
    $this->registerJs("alert('$str')");
}
$this->title = 'Написать администрации';
$this->params['breadcrumbs'][] = $this->title;
?>
<main id="cat" class="contact">
    <div class="wrap category pr">
        <h1><?= Html::encode($this->title) ?></h1>
        <div class="grey-line"></div>

        <?php if (Yii::$app->session->hasFlash('contactFormSubmitted')): ?>

            <div class="alert alert-success">
                Спасибо! Ваше письмо отправлено.
            </div>


        <?php else: ?>


            <?php $form = ActiveForm::begin([
                'id' => 'contact-form',
                'enableAjaxValidation' => false,
                'enableClientValidation' => false,
                'fieldClass' => MyActiveField::className(),
                'options' => ['enctype' => 'multipart/form-data']
            ]); ?>
            <div class="contact-left fl">
                <?= $form->field($model, 'subject')->label(false)->radioList([
                        '1' => 'Написать в Отдел Заказов',
                        '2' => 'Написать Администрации Комплекса',
                        '3' => 'Отправить Коммерческое Предложение',
                        '4' => 'Написать Благодарность',
                        '5' => 'Написать Жалобу',
                ], [
                    'item' => function($index, $label, $name, $checked, $value) {

                        $return = '<label>';
                        $return .= '<input type="radio" name="' . $name . '" value="' . $value . '" >';
                        $return .= '<span>' . ucwords($label) . '</span>';
                        $return .= '</label>';

                        return $return;
                    }
                ]) ?>

                <?= $form->field($model, 'email')->label(false)->textInput(['placeholder' => 'E-mail']) ?>

                <?= $form->field($model, 'name')->label(false)->textInput(['placeholder' => 'Ваше имя']) ?>

            </div>
            <div class="contact-right fl">
                <?= $form->field($model, 'body')->label(false)->textarea(['rows' => 6, 'placeholder' => 'Текст']) ?>
                <div class="upload">
                    <span class="link">Прикрепить файл</span>
                    &nbsp<span class="file"></span>
                    <?= $form->field($model, 'file')->label(false)->fileInput(); ?>
                </div>
            </div>

            <div class="clear"></div>
            <div class="btn-container">
                <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>


        <?php endif; ?>
    </div>
</main>
