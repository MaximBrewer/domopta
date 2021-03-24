<?php
/* @var $this \yii\web\View */
/* @var $model \app\models\ForgotForm */

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\widgets\MaskedInput;
?>
<div class="container container_pop-small">
	<div class="reg-pop-inner">
		<div class="reg-pop__step1 reg-pop__step1_block">
			<?php $form = ActiveForm::begin([
				'id' => 'forgot-form',
				'enableAjaxValidation' => false,
				'action' => '/site/forgotvalidation'
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
			<div class="reg-pop__txt">На Ваш номер телефона будет отправлено смс с новым паролем.</div>
			<div class="reg-pop__row">
				<?php echo \himiklab\yii2\recaptcha\ReCaptcha::widget([
					'model' => $model,
					'attribute' => 'recaptcha',
				]) ?>
			</div>
			<div id="forgotform-phone-error"></div>
			<div id="forgotform-recaptcha-error"></div>
			<div class="reg-pop__row reg-pop__row_btn">
				<input class="reg-pop__btn" type="submit" value="Восстановить пароль">
			</div>
			<?php ActiveForm::end() ?>
		</div>
		<a href="#" id="esc" class="esc">
			<div class="esc__icon esc__icon_cross1">
				<svg class="svg esc__svg esc__svg_cross1">
					<use xlink:href="/img/sprite-sheet.svg#cross1" />
				</svg>
			</div>
		</a>
	</div>
</div>