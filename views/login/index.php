<?php
/* @var $this \yii\web\View */
/* @var $model \app\models\LoginForm */
/* @var $form \yii\widgets\ActiveForm */

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\MaskedInput;
?>
<div class="container container_pop-small">
	<div class="log-pop-inner">
		<div class="reg-log-nav log-pop__reg-log-nav">
			<ul class="reg-log-nav__list">
				<li class="reg-log-nav__item">
					<a href="#" class="reg-log-nav__link js-reg-tab"> Регистрация</a>
				</li>
				<li class="reg-log-nav__item reg-log-nav__item_active">
					<a href="#" class="reg-log-nav__link js-login-tab">Войти</a>
				</li>
			</ul>
		</div>
		<?php $form = ActiveForm::begin(['id' => 'login-form', 'action' => Url::to(['/login/validate'])]); ?>

		<div class="log-pop__row">
			<div class="active-input">НОМЕР ТЕЛЕФОНА</div>
			<?php echo MaskedInput::widget([
				'model' => $model,
				'attribute' => 'login',
				'mask' => '+7 (999) 999-99-99',
				'options' => ['placeholder' => 'НОМЕР ТЕЛЕФОНА', 'class' => 'log-pop__input'],
				'clientOptions' => [
					'placeholder' => ' '
				]
			]) ?>
			<div id="loginform-login-error"></div>
		</div>
		<div class="log-pop__row">
			<div class="active-input">ПАРОЛЬ</div>
			<div style="position:relative;margin-bottom:10px;">
				<?php echo Html::activePasswordInput($model, 'password', ['placeholder' => 'ПАРОЛЬ', 'class' => 'log-pop__input', 'style' => "margin-bottom:0px;"]) ?>
				<span id="show_password" class="show_password">
					<span class="eye-icon">
						<svg class="svg product__svg product__svg_eye">
							<use xlink:href="/img/sprite-sheet.svg#eye" />
						</svg>
						<span class="line"></span>
					</span>
				</span>
			</div>
			<div id="loginform-password-error"></div>
		</div>
		<div class="log-pop__recovery">
			<a href="#" class="log-pop__recovery-link">Забыли пароль?</a>
		</div>
		<div class="log-pop__row log-pop__row_btn">
			<?php echo Html::submitInput('Войти', ['class' => 'log-pop__btn js-login']) ?>
		</div>
		<?php ActiveForm::end() ?>
		<a href="#" id="esc" class="esc">
			<div class="esc__icon esc__icon_cross1">
				<svg class="svg esc__svg esc__svg_cross1">
					<use xlink:href="/img/sprite-sheet.svg#cross1" />
				</svg>
			</div>
		</a>
	</div>
</div>