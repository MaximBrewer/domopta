<?php

/**
 * Created by PhpStorm.
 * User: resh
 * Date: 23.01.19
 * Time: 12:56
 */
/* @var $this \yii\web\View */
/* @var $user \app\models\User */
/* @var $profile \app\models\Profile */
/* @var $form \yii\widgets\ActiveForm */

use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>
<div class="content content_flip main__content">
	<div class="container container_fl-wr">
		<div class="content-left">
			<div class="register">
				<div class="register-top">
					<div class="content__title">Pегистрация <span>(Шаг 3 из 3)</span></div>
				</div>
				<div class="register-bottom">
					<div class="register-left">
						<div class="register__form">
							<?php $form = ActiveForm::begin([
								'options' => ['enctype' => 'multipart/form-data']
							]); ?>
							<div class="register__row">
								<div class="active-input"><span class="required">*</span>Фамилия</div>
								<?php echo Html::activeTextInput($profile, 'lastname', ['placeholder' => 'Фамилия *', 'class' => 'register__input ' . ($profile->hasErrors('lastname') ? 'has-error' : '')]) ?>
								<?php if ($err = $profile->getErrors('lastname')) : ?>
									<div class="reg-error"><?php echo $err[0] ?></div>
								<?php endif; ?>
							</div>
							<div class="register__row">
								<div class="active-input"><span class="required">*</span>Имя</div>
								<?php echo Html::activeTextInput($profile, 'name', ['placeholder' => 'Фамилия *', 'class' => 'register__input ' . ($profile->hasErrors('name') ? 'has-error' : '')]) ?>
								<?php if ($err = $profile->getErrors('name')) : ?>
									<div class="reg-error"><?php echo $err[0] ?></div>
								<?php endif; ?>
							</div>
							<div class="register__row">
								<div class="active-input">Отчество</div>
								<?php echo Html::activeTextInput($profile, 'surname', ['placeholder' => 'Фамилия *', 'class' => 'register__input ' . ($profile->hasErrors('surname') ? 'has-error' : '')]) ?>
								<?php if ($err = $profile->getErrors('surname')) : ?>
									<div class="reg-error"><?php echo $err[0] ?></div>
								<?php endif; ?>
							</div>
							<div class="register__row">
								<div class="active-input"><span class="required">*</span>Регион</div>
								<?php echo Html::activeTextInput($profile, 'region', ['placeholder' => 'Регион *', 'class' => 'register__input ' . ($profile->hasErrors('region') ? 'has-error' : '')]) ?>

								<?php if ($err = $profile->getErrors('region')) : ?>
									<div class="reg-error"><?php echo $err[0] ?></div>
								<?php endif; ?>
							</div>
							<div class="register__row">
								<div class="active-input"><span class="required">*</span>Город</div>
								<?php echo Html::activeTextInput($profile, 'city', ['placeholder' => 'Город *', 'class' => 'register__input ' . ($profile->hasErrors('city') ? 'has-error' : '')]) ?>

								<?php if ($err = $profile->getErrors('city')) : ?>
									<div class="reg-error"><?php echo $err[0] ?></div>
								<?php endif; ?>
							</div>
							<?php if ($profile->type != 2) : ?>
								<?php if ($profile->type != 1) : ?>
									<div class="register__row" id="reg_org">
										<div class="active-input"><span class="required">*</span>Название организации</div>
										<?php echo Html::activeTextInput($profile, 'organization_name', ['placeholder' => 'Название организации', 'class' => 'register__input ' . ($profile->hasErrors('organization_name') ? 'has-error' : '')]) ?>

										<?php if ($err = $profile->getErrors('organization_name')) : ?>
											<div class="reg-error"><?php echo $err[0] ?></div>
										<?php endif; ?>
									</div>
									<div class="register__row" id="reg_location">
										<div class="active-input"><span class="required">*</span>Юридический адрес</div>
										<?php echo Html::activeTextInput($profile, 'location', ['placeholder' => 'Юридический адрес', 'class' => 'register__input ' . ($profile->hasErrors('location') ? 'has-error' : '')]) ?>

										<?php if ($err = $profile->getErrors('location')) : ?>
											<div class="reg-error"><?php echo $err[0] ?></div>
										<?php endif; ?>
									</div>
								<?php endif; ?>
								<div class="register__row">
									<div class="active-input"><span class="required">*</span>ИНН или ОГРН</div>
									<?php echo Html::activeTextInput($profile, 'inn', ['placeholder' => 'ИНН или ОГРН *', 'class' => 'register__input ' . ($profile->hasErrors('inn') ? 'has-error' : '')]) ?>

									<?php if ($err = $profile->getErrors('inn')) : ?>
										<div class="reg-error"><?php echo $err[0] ?></div>
									<?php endif; ?>
								</div>
							<?php endif; ?>

							<div class="register__row">
								<div class="active-input">Телефон</div>
								<?php echo Html::activeTextInput($user, 'username', ['class' => 'register__input', 'disabled' => true]) ?>
							</div>
							<div class="register__row">
								<div class="active-input">Email</div>
								<?php echo Html::activeTextInput($user, 'email', ['placeholder' => 'Email', 'class' => 'register__input ' . ($user->hasErrors('email') ? 'has-error' : '')]) ?>

								<?php if ($err = $user->getErrors('email')) : ?>
									<div class="reg-error"><?php echo $err[0] ?></div>
								<?php endif; ?>
								<p class="not-red">Если Вы хотите получать на почту свои заказы, то Вам необходимо ввести свой e-mail.</p>
							</div>
							<?php /* 
							<div class="register__row">
								<div class="active-input">Пароль</div>
								<?php echo Html::activePasswordInput($user, 'password', ['placeholder' => 'Пароль', 'class' => 'register__input ' . ($user->hasErrors('password') ? 'has-error' : '')]) ?>

								<?php if ($err = $profile->getErrors('password')) : ?>
									<div class="reg-error"><?php echo $err[0] ?></div>
								<?php endif; ?>
							</div>
							<div class="register__row">
								<div class="active-input">Подтвердите пароль</div>
								<?php echo Html::activePasswordInput($user, 'password_repeat', ['placeholder' => 'Подтвердите пароль', 'class' => 'register__input ' . ($user->hasErrors('password_repeat') ? 'has-error' : '')]) ?>

								<?php if ($err = $profile->getErrors('password_repeat')) : ?>
									<div class="reg-error"><?php echo $err[0] ?></div>
								<?php endif; ?>
							</div>
							*/ ?>
							<div class="register__row">
								<div class="active-input">Комментарий</div>
								<?php echo Html::activeTextarea($profile, 'users_comment', ['placeholder' => 'Комментарий', 'class' => 'register__input feedback__input_text' . ($user->hasErrors('users_comment') ? 'has-error' : '')]) ?>

								<?php if ($err = $profile->getErrors('users_comment')) : ?>
									<div class="reg-error"><?php echo $err[0] ?></div>
								<?php endif; ?>
								<small class="required">* Поля отмеченные звездочкой обязательны для заполнения</small>
							</div>
							<?php /* 
							<!--<div class="register__row">
								<label for="file-input" class="file-input">
									<span class='file-input__icon'>
										<svg class="file-input__svg">
											<use xlink:href="/img/sprite-sheet.svg#attach" />
										</svg>
									</span>
									<span class="file-input__text1">Загрузить копии документов</span>
								</label>
								<?php echo Html::activeFileInput($user, 'docs[]', ['multiple' => true, 'class' => 'file-input', 'id' => 'file-input']) ?>

								<div class="file-input__text2">В формате jpg, pdf, doc, docx</div>
							</div>-->
							<!--<div class="register__row">
                                <span>* Поля, отмеченные звездочкой обязательны для заполнения</span>
                            </div>-->
							<!--<div class="register__row">
								<label for="register__input-check" class="reg-checkbox <?php echo YII::$app->request->isPost && YII::$app->request->post('agree') == 0 ? 'has-error' : '' ?>">
									<label>
										<input class="checkbox" id="register__input-check" type="checkbox" placeholder="placeholder" name="agree">
									</label>
									<span class="checkmark">
										<svg class="checkmark__svg checkmark__svg_check">
											<use xlink:href="/img/sprite-sheet.svg#check" />
										</svg>
									</span>
								</label>

								<span>Я согласен с обработкой персональных данных и <br><a href="/politika-konfidencialnosti" class="text-link" target="_blank">политикой&nbsp;конфиденциальности</a></span>
							</div>-->
							*/ ?>
							<div class="register__row register__row_btn text-center">
								<input class="register__btn" type="submit" value="Зарегистрироваться"><br>
							</div>

							<?php ActiveForm::end() ?>
						</div>
					</div>
					<div class="register-right">
					</div>
				</div>
			</div>
		</div>
		<div class="content-right">

		</div>
	</div>
</div>