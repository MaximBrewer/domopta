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

/**
 * @var yii\web\View $this
 * @var \app\models\RegistrationForm $model
 * @var dektrium\user\Module $module
 */

$this->title = Yii::t('user', 'Sign up');
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile('/js/register.js', ['depends' => \app\assets\AppAsset::className()]);

?>
<div class="row">
    <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
            </div>
            <div class="panel-body">
                <?php $form = ActiveForm::begin([
                    'id' => 'registration-form',
                    'enableAjaxValidation' => false,
                    'enableClientValidation' => false,
                    'fieldClass' => MyActiveField::className()
                ]); ?>

                <?= $form->field($model, 'type')->label(false)->radioList([
                        'ip' => 'Предприниматель, ИП',
                        'ooo' => 'Юридическое лицо ООО',
                        'sp' => 'Организатор СП'
                ]) ?>
                <?= $form->field($model, 'lastname') ?>
                <?= $form->field($model, 'name') ?>
                <?= $form->field($model, 'surname') ?>
                <?= $form->field($model, 'city') ?>
                <?= $form->field($model, 'region') ?>
                <?= $form->field($model, 'organization_name', ['options' => ['class' => 'hidden']]) ?>
                <?= $form->field($model, 'phone') ?>
                <?= $form->field($model, 'email') ?>
                <?= $form->field($model, 'inn', ['options' => ['class' => 'hidden']]) ?>
                <?= $form->field($model, 'users_comment') ?>

                <?= $form->field($model, 'capcha')->widget(\yii\captcha\Captcha::className(),[
                    'captchaAction' => ['/site/captcha']
                ]) ?>
                <?= $form->field($model, 'agree')->checkbox([
                        'label' => 'Я согласен с '.Html::a('Условиями использования сайта', '#').' и даю согласие на хранение и обработку своих данных.'
                ]) ?>

                <?php if ($module->enableGeneratingPassword == false): ?>
                    <?= $form->field($model, 'password')->passwordInput() ?>
                <?php endif ?>

                <?= Html::submitButton(Yii::t('user', 'Sign up'), ['class' => 'btn btn-success btn-block']) ?>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
        <p class="text-center">
            <?= Html::a(Yii::t('user', 'Already registered? Sign in!'), ['/user/security/login']) ?>
        </p>
    </div>
</div>
