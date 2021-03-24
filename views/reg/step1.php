<?php
/* @var $this \yii\web\View */
/* @var $model \app\models\MobRegForm */
/* @var $form ActiveForm */

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\widgets\MaskedInput;
?>
<div class="container container_pop-small">
	<div class="reg-pop-inner">
		<div class="reg-log-nav reg-pop__reg-log-nav">
			<ul class="reg-log-nav__list">
				<li class="reg-log-nav__item reg-log-nav__item_active">
					<a href="#" class="reg-log-nav__link js-reg-tab"> Регистрация</a>
				</li>
				<li class="reg-log-nav__item">
					<a href="#" class="reg-log-nav__link js-login-tab">Войти</a>
				</li>
			</ul>
		</div>
		<div class="reg-pop__step1 reg-pop__step1_block">
            <?php $form = ActiveForm::begin([
                    'id' => 'reg-form',
                    'enableAjaxValidation' => false,
                    'action' => '/reg/step1validation'
            ]) ?>

				<div class="reg-pop__row">
					<div class="active-input">НОМЕР ТЕЛЕФОНА</div>
                    <?php echo MaskedInput::widget([
	                    'model' => $model,
	                    'attribute' => 'phone',
	                    'mask' => '+7 (999) 999-99-99',
	                    'options' => ['placeholder' => 'ВВЕДИТЕ номер телефона', 'class' => 'reg-pop__input'],
	                    'clientOptions' => [
		                    'placeholder' => ' '
	                    ]
                    ]) ?>
				</div>
				<div class="reg-pop__txt">На Ваш номер телефона будет отправлено смс с кодом для подтверждения регистрации.</div>
                <div id="mobregform-phone-error"></div>
				<div class="reg-pop__row">
					<label for="checkbox-reg" class="reg-checkbox">
						<span class="checkmark">
							<svg class="checkmark__svg checkmark__svg_check checkmark__svg_pop">
								<use xlink:href="/img/sprite-sheet.svg#check"/>
							</svg>
						</span>
					</label>
					<?php echo Html::activeCheckbox($model, 'agree', ['id'=>'checkbox-reg','class' => 'checkbox', 'label' => '<span class="reg-pop__pol">Я согласен с обработкой персональных данных и <a href="/politika-konfidencialnosti" class="reg-pop__pol-link">политикой&nbsp;конфиденциальности</a></span>']) ?>
				</div>
				<div class="reg-pop__row reg-pop__row_btn">
					<input class="reg-pop__btn" type="submit" value="Зарегистрироваться">
				</div>
			<?php ActiveForm::end() ?>
		</div>
		<div class="reg-pop__step2">
			<?php $form = ActiveForm::begin([
				'id' => 'reg-form-2',
				'enableAjaxValidation' => false,
				'action' => '/reg/step2validation',
			]) ?>
				<div class="reg-pop__row">
                    <?php echo Html::activeInput('text', $model, 'phone2', ['readonly' => true, 'class' => 'reg-pop__input']) ?>
				</div>
                <div id="mobregform-phone2-error"></div>
				<div class="reg-pop__row">
					<?php echo Html::activeInput('text', $model, 'code', ['placeholder' => 'Введите код из SMS', 'class' => 'reg-pop__input']) ?>
				</div>
                <div id="mobregform-code-error"></div>
				<div class="reg-pop__row reg-pop__row_btn">
					<input class="reg-pop__btn" type="submit" value="Подтвердить">
				</div>
			<?php ActiveForm::end() ?>
		</div>
		<a href="#" id="esc" class="esc">
			<div class="esc__icon esc__icon_cross1">
				<svg class="svg esc__svg esc__svg_cross1">
					<use xlink:href="/img/sprite-sheet.svg#cross1"/>
				</svg>
			</div>
		</a>
	</div>
</div>
