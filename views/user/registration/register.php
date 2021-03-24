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
use app\components\Breadcrumbs;

/**
 * @var yii\web\View $this
 * @var \app\models\RegistrationForm $model
 * @var dektrium\user\Module $module
 */

$this->params['breadcrumbs'][] = 'Регистрация';

$this->registerJsFile('/js/register.js', ['depends' => \yii\web\JqueryAsset::className()]);

if($model->hasErrors()){
    $str = '';
    foreach ($model->getErrors() as $error){
        $str .= $error[0] . "\\n";
    }
    $this->registerJs("alert('$str')");
}
?>
<main id="cat">
    <div class="wrap reg pr">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            'homeLink' => [
                'label' => 'Главная',
                'url' => '/'
            ],
            'tag' => 'div',
            'options' => ['class' => 'bread'],
            'itemTemplate' => '{link}',
            'activeItemTemplate' => '{link}',
            'glue' => ' > '

        ]) ?>
        <div class="cat_desc">
            <?= Yii::$app->params['page']->text; ?>
        </div>


        <div class="stat_title">РЕГИСТРАЦИЯ</div>

        <div class="register">
            <?php $form = ActiveForm::begin([
                'id' => 'registration-form',
                'enableAjaxValidation' => false,
                'enableClientValidation' => false,
                'fieldClass' => MyActiveField::className()
            ]); ?>
            <div class="reg_left fl">
                <?= $form->field($model, 'lastname') ?>
                <?= $form->field($model, 'name') ?>
                <?= $form->field($model, 'surname') ?>
                <?= $form->field($model, 'city') ?>
                <?= $form->field($model, 'region') ?>
                <span class="field-register-form-organozation_name">
                    <?= $form->field($model, 'organization_name', ['options' => ['disabled' => true]]) ?>
                </span>
                <?= $form->field($model, 'phone')->widget(\yii\widgets\MaskedInput::className(),
                    [
                        'mask' => '+7 (999) 999-99-99',
                        'options' => ['placeholder' => '+7']
                    ]
                ) ?>

                <div class="reg_info_text">Контактный номер мобильного телефона. <br>Например: +7 (908) 123-45-67</div>

                <?= $form->field($model, 'email') ?>
                <div class="reg_info_text">Адрес электронной почты будет <br>использоваться для авторизации</div>



                <span class="field-register-form-inn">
                    <?= $form->field($model, 'inn', ['options' => ['disabled' => true]]) ?>
                </span>
 <div class="reg_info_text">Данная информация необходима только для подтверждения, что Вы
действительно являетесь Предпринимателем или Юридическим лицом </div>


                <?= $form->field($model, 'password')->passwordInput() ?>
                <div class="reg_info_text">Пароль должен быть не короче 3-х символов и содержать цифры и буквы для лучшей защиты</div>
                <?= $form->field($model, 'password_repeat')->passwordInput() ?>
                <div class="reg_info_text">Повторите только что введенный пароль</div>
                <?= $form->field($model, 'users_comment')->textarea() ?>
            </div>

            <div class="reg_right fl">
                <?= $form->field($model, 'type')->label(false)->radioList([
                    'ip' => 'Предприниматель, ИП',
                    'ooo' => 'Юридическое лицо, ООО',
                    'sp' => 'Организатор СП'
                ],[
                'item' => function ($index, $label, $name, $checked, $value) use ($model){
                    if(!$model->type && $value == 'ip'){
                        $checked = 1;
                    }
                    return Html::radio($name, $checked, ['value' => $value, 'class' => $model->hasErrors('type')?'error':'']) . $label .'<br />';
                }
                ]) ?>


                <div class="reg_text">
                    <div class="reg_text_hide">
                    <span>Контактный номер мобильного телефона.<br>Например: +7 (908) 123-45-67</span>
               
                    <span>Адрес электронной почты будет<br>использоваться для авторизации</span>
					<span>Данная информация необходима только для подтверждения, что Вы<br /> действительно являетесь Предпринимателем или Юридическим лицом</span>
                    <span>Пароль  должен быть не короче 3-х символов и содержать цифры и буквы для лучшей защиты</span>
                    <span>Повторите только что введенный пароль</span>
                   </div>

                    <div class="sogl <?php echo $model->hasErrors('agree')?'error':''; ?>">
                        <?php echo $form->field($model, 'agree', ['template' => '{input}'])->label(false)->radio(['enclosedByLabel' => false]) ?>
                        Я согласен с <a href="/polzovatelskoe-soglasenie" target="_blank">Условиями использования сайта</a><br> и даю согласие на хранение и обработку<br> своих данных.
                    </div>
                </div>
            </div>
            <div class="clear"></div>

            <?php echo Html::submitInput('ЗАРЕГИСТРИРОВАТЬСЯ', ['class' => 'regis reg-btn']) ?>

            <div class="seo_text">
                <?= Yii::$app->params['page']->additional_text; ?>
            </div>
            <div class="clear"></div>
            <?php ActiveForm::end(); ?>
        </div>




    </div>
</main>
