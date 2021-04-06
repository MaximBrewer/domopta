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
					<div class="content__title">Мой профиль</div>
				</div>
				<div class="profile-bottom">
					<div class="profile-left">
						<div class="profile__form">
							<?php $form = ActiveForm::begin([
								'options' => ['enctype' => 'multipart/form-data']
							]); ?>
							<?php echo Html::activeHiddenInput($profile, 'type') ?>

							<div class="profile__row">
								<div class="active-input">Фамилия Имя Отчество</div>
								<input type="text" class="profile__input" value="<?php echo $profile->lastname . ' ' . $profile->name . ' ' . $profile->surname; ?>" readonly="">
							</div>

							<div class="profile__row">
								<div class="active-input">Регион</div>
								<input type="text" class="profile__input" value="<?php echo $profile->region; ?>" readonly="">
							</div>
							<div class="profile__row">
								<div class="active-input">Город</div>
								<input type="text" class="profile__input" value="<?php echo $profile->city; ?>" readonly="">
							</div>
							<?php if ($profile->type == 3) : ?>
								<div class="profile__row">
									<div class="active-input">Юридический адрес</div>
									<input type="text" class="profile__input" value="<?php echo $profile->location; ?>" readonly="">
								</div>
								<div class="profile__row">
									<div class="active-input">Название организации</div>
									<input type="text" class="profile__input" value="<?php echo $profile->organization_name; ?>" readonly="">
								</div>
							<?php endif; ?>
							<?php if ($profile->type != 2) : ?>
								<div class="profile__row">
									<div class="active-input">ИНН или ОГРН</div>
									<input type="text" class="profile__input" value="<?php echo $profile->inn; ?>" readonly="">
								</div>
							<?php endif; ?>
							<div class="profile__row">
								<div class="active-input">Телефон</div>
								<input type="text" class="profile__input" value="<?php echo $user->username; ?>" readonly="">
							</div>
							<div class="profile__input-name">Сменить E-mail</div>
							<div class="profile__row">
								<div class="active-input">Email</div>
								<?php echo Html::activeTextInput($user, 'email', ['placeholder' => 'Email', 'class' => 'profile__input ' . ($user->hasErrors('email') ? 'has-error' : '')]) ?>
								<?php if ($err = $user->getErrors('email')) : ?>
									<p class="red"><?php echo $err[0] ?></p>
								<?php else : ?>
									<?php if ($user->email != '' && $user->unconfirmed_email) : ?>
										<p class="not-red">E-mail подтвержден. Если хотите свой e-mail изменить, то введите новый e-mail.</p>
									<?php elseif ($user->email != '') : ?>
										<p class="red">Email не подтвержден. <a href="/cabinet/resend">Выслать письмо повторно?</a></p>
									<?php else : ?>
										<p class="not-red">Если Вы хотите получать на почту свои заказы, то Вам необходимо ввести свой e-mail.</p>
									<?php endif; ?>
								<?php endif; ?>
							</div>
							<div class="profile__input-name">Сменить пароль</div>
							<div class="profile__row">
								<div class="active-input">Новый пароль</div>
								<div style="position:relative">
									<?php echo Html::activePasswordInput($user, 'password', ['placeholder' => 'Пароль', 'minlength' => 6, 'class' => 'profile__input ' . ($user->hasErrors('password') ? 'has-error' : '')]) ?>
									<span id="show_password2" class="show_password">
										<span class="eye-icon">
											<svg class="svg product__svg product__svg_eye">
												<use xlink:href="/img/sprite-sheet.svg#eye" />
											</svg>
											<span class="line"></span>
										</span>
									</span>
								</div>
								<?php if ($err = $user->getErrors('password')) : ?>
									<p class="red"><?php echo $err[0] ?></p>
								<?php endif; ?>
							</div>
							<div class="profile__row">
								<div class="active-input">Подтвердите пароль</div>
								<div style="position:relative">
									<?php echo Html::activePasswordInput($user, 'password_repeat', ['placeholder' => 'Подтвердите пароль', 'class' => 'profile__input ' . ($user->hasErrors('password_repeat') ? 'has-error' : '')]) ?>
									<span id="show_password3" class="show_password">
										<span class="eye-icon">
											<svg class="svg product__svg product__svg_eye">
												<use xlink:href="/img/sprite-sheet.svg#eye" />
											</svg>
											<span class="line"></span>
										</span>
									</span>
								</div>
								<?php if ($err = $user->getErrors('password_repeat')) : ?>
									<p class="red"><?php echo $err[0] ?></p>
								<?php endif; ?>

							</div>
							<div class="profile__row profile__row_btn">
								<input class="profile__btn" type="submit" value="Сохранить">
							</div>

							<?php ActiveForm::end() ?>
						</div>
					</div>
					<div class="profile-right">
						<div class="price-category">
							<?php if ($profile->type == 1) : ?>
								<div class="price-category__heading">Ваша категория: <div class="price-category__text1">Индивидуальные Предприниматели</div>
								</div>
								<div class="price-category__heading">Тип цен: <span class="price-category__text2">Опт</span></div>
							<?php elseif ($profile->type == 3) : ?>
								<div class="price-category__heading">Ваша категория: <div class="price-category__text1">Юридические лица</div>
								</div>
								<div class="price-category__heading">Тип цен: <span class="price-category__text2">Опт</span></div>
							<?php elseif ($profile->type == 2) : ?>
								<div class="price-category__heading">Ваша категория: <div class="price-category__text">Физические лица</div>
								</div>
								<div class="price-category__heading">Тип цен: <span class="price-category__text2">Мелкий опт</span></div>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="content-right">
			<div class="user-btns">
				<div class="content__title">Личный кабинет</div>
				<div class="drop-content content-btn__drop-content drop-content_phone">
					<a href="#" class="drop-content__link" id="cab">
						<div class="drop-content__text">
							<span>Личнй кабинет</span>
							<div class="drop-content__icon">
								<svg class="svg drop-content__svg drop-content__svg_arrow2-dn">
									<use xlink:href="/img/sprite-sheet.svg#arrow2-dn" />
								</svg>
							</div>
						</div>
					</a>
				</div>
				<ul class="user-btns__list">
					<li class="user-btns__item user-btns__item_active">
						<a href="/cabinet" class="user-btns__link">Мой профиль</a>
					</li>
					<li class="user-btns__item">
						<a href="/history" class="user-btns__link">История заказов</a>
					</li>
					<li class="user-btns__item">
						<a href="/favorites" class="user-btns__link">Избранное</a>
					</li>
					<li class="user-btns__item">
						<a href="/site/logout" class="user-btns__link">Выход</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>
<?php if (Yii::$app->session->getFlash('reg-success')) : ?>
	<div class="log-pop log-pop_flex">
		<div class="container container_pop-small">
			<div class="reg-pop-inner reg-pop-inner-fav reg-pop-inner-success">
				<div class="reg-pop__step1 reg-pop__step1_block">
					<p class="popup-text1">Регистрация на сайте завершена.</p>
					<p class="popup-text2">Добро пожаловать на сайт!</p>
				</div>
				<a href="#" id="esc" class="esc">
					<div class="esc__icon esc__icon_cross1">
						<svg class="svg esc__svg esc__svg_cross1">
							<use xlink:href="/img/sprite-sheet.svg#cross1"></use>
						</svg>
					</div>
				</a>
			</div>
		</div>
	</div>
<?php endif; ?>
<?php if (Yii::$app->session->getFlash('save_success')) : ?>
	<div class="log-pop log-pop_flex">
		<div class="container container_pop-small">
			<div class="reg-pop-inner reg-pop-inner-fav reg-pop-inner-success">
				<div class="reg-pop__step1 reg-pop__step1_block">
					<p class="popup-text1">Изменения сохранены.</p>
				</div>
				<a href="#" id="esc" class="esc">
					<div class="esc__icon esc__icon_cross1">
						<svg class="svg esc__svg esc__svg_cross1">
							<use xlink:href="/img/sprite-sheet.svg#cross1"></use>
						</svg>
					</div>
				</a>
			</div>
		</div>
	</div>
<?php endif; ?>
<?php if (Yii::$app->session->getFlash('password_changed')) : ?>
	<div class="log-pop log-pop_flex">
		<div class="container container_pop-small">
			<div class="reg-pop-inner reg-pop-inner-fav reg-pop-inner-success">
				<div class="reg-pop__step1 reg-pop__step1_block">
					<p class="popup-text1 py-3 px-4">Пароль успешно изменен.<br>
						Произведен выход из аккаунта на всех устройствах, где был ранее осуществлен вход с предыдущим паролем.</p>
				</div>
				<a href="#" id="esc" class="esc">
					<div class="esc__icon esc__icon_cross1">
						<svg class="svg esc__svg esc__svg_cross1">
							<use xlink:href="/img/sprite-sheet.svg#cross1"></use>
						</svg>
					</div>
				</a>
			</div>
		</div>
	</div>
<?php endif; ?>