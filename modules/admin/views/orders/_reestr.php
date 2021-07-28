<?php
/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\widgets\MyActiveField;
use yii\jui\DatePicker;

/**
 * @var yii\web\View $this
 * @var \app\models\OrderReestrForm $model
 * @var dektrium\user\Module $module
 */
?>
<?php $form = ActiveForm::begin([
    'id' => 'xls-form',
    'action' => '/' . MODULE_ID . '/orders/reestr',
    'options' => [
        'onsubmit' => '$(\'#reestr-modal\').modal(\'hide\')'
    ]
]); ?>
<div class="row">
    <div class="col-sm-6">
        <?= $form->field($model, 'from')->widget(DatePicker::class, [
            'language' => 'ru',
            'dateFormat' => 'dd.MM.yyyy',
            'options' => [
                'placeholder' => Yii::$app->formatter->asDate($model->from),
                'class' => 'form-control',
                'autocomplete' => 'off'
            ],
            'clientOptions' => [
                'changeMonth' => true,
                'changeYear' => true,
                'yearRange' => '2000:2050',
                //'showOn' => 'button',
                //'buttonText' => 'Выбрать дату',
                //'buttonImageOnly' => true,
                //'buttonImage' => 'images/calendar.gif'
            ]
        ])->label(false) ?>
    </div>
    <div class="col-sm-6">
        <?= $form->field($model, 'to')->widget(DatePicker::class, [
            'language' => 'ru',
            'dateFormat' => 'dd.MM.yyyy',
            'options' => [
                'placeholder' => Yii::$app->formatter->asDate($model->to),
                'class' => 'form-control',
                'autocomplete' => 'off'
            ],
            'clientOptions' => [
                'changeMonth' => true,
                'changeYear' => true,
                'yearRange' => '2000:2050',
                //'showOn' => 'button',
                //'buttonText' => 'Выбрать дату',
                //'buttonImageOnly' => true,
                //'buttonImage' => 'images/calendar.gif'
            ]
        ])->label(false) ?>
    </div>
</div>
<?= Html::submitButton('Скачать', ['class' => 'btn btn-success btn-block']) ?>
<?php ActiveForm::end(); ?>