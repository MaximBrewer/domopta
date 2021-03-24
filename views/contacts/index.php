<?php
/* @var $this \yii\web\View */
?>

        <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
		
<div class="content">
	<div class="container">
		<div class="contacts">
			<div class="contacts-top">
				<div class="content__title">Контакты</div>
			</div>
			<div class="contacts-bottom">
				<div class="contacts-left">
					<ul class="contacts__list">
						<li class="contacts__item">
							<div class="common">
								<span class="common__heading">Свяжитесь с нами</span>
								<ul class="common__list common__list_show">
									<li class="common__item common__item_flex">
										<div class="common__icon">
											<svg class="common__svg common__svg_comments">
												<use xlink:href="/img/sprite-sheet.svg#comments"></use>
											</svg>
										</div>
										<ul class="contacts__list">
											<li class="contacts__item">
												<a href="tel:<?php echo Yii::$app->settings->get('Settings.phone_call') ?>" class="support-header-top"><?php echo Yii::$app->settings->get('Settings.phone_call') ?></a>
												<div class="support-header-bottom">Бесплатно по РФ</div>
											</li>
											<li class="contacts__item">
												<a href="tel:<?php echo Yii::$app->settings->get('Settings.phone_order') ?>" class="support-header-top"><?php echo Yii::$app->settings->get('Settings.phone_order') ?></a>
												<div class="support-header-bottom">АДМИНИСТРАЦИЯ</div>
											</li>
											<li class="contacts__item">
												<a href="tel:<?php echo Yii::$app->settings->get('Settings.phone_admin') ?>" class="support-header-top"><?php echo Yii::$app->settings->get('Settings.phone_admin') ?></a>
												<div class="support-header-bottom">КОНСУЛЬТАЦИЯ</div>
											</li>
											<li class="contacts__item">
												<a href="tel:<?php echo Yii::$app->settings->get('Settings.phone') ?>" class="support-header-top"><?php echo Yii::$app->settings->get('Settings.phone') ?></a>
												<div class="support-header-bottom">ОТДЕЛ ЗАКАЗОВ</div>
											</li>
										</ul>
									</li>
								</ul>
							</div>
						</li>
						<li class="contacts__item">
							<div class="common">
								<span class="common__heading">Адрес</span>
								<ul class="common__list">
									<li class="common__item common__item_flex common__item_mb">
										<div class="common__icon">
											<svg class="svg common__svg common__svg_place">
												<use xlink:href="/img/sprite-sheet.svg#place"></use>
											</svg>
										</div>
										<div class="text-header footer__text-header">
											<div class="text-header-top">ОПТОВЫЙ КОМПЛЕКС<br> “ЛЕГКИЙ ВЕТЕР”</div>
											<div class="text-header-bottom"><?php echo Yii::$app->settings->get('Settings.addresses') ?></div>
										</div>
									</li>
									<li class="common__item common__item_flex">
										<div class="common__icon">
											<svg class="svg common__svg common__svg_time">
												<use xlink:href="/img/sprite-sheet.svg#time"></use>
											</svg>
										</div>
										<div class="fotter-schedule">
											<div class="fotter-schedule-top"><?php echo Yii::$app->settings->get('Settings.time') ?></div>
										</div>
									</li>
								</ul>
							</div>
						</li>
						<li class="contacts__item">
							<div class="common">
								<span class="common__heading">Мы в социальных сетях</span>
								<ul class="common__list common__list_flex common__list_pt">
									<?php if(Yii::$app->settings->get('Settings.social_instagram')): ?>
										<li class="common__item">
											<a href="<?php echo Yii::$app->settings->get('Settings.social_instagram') ?>" class="common__link common__icon" target="_blank" rel="nofollow">
												<svg class="common__svg common__svg_insta">
													<use xlink:href="/img/sprite-sheet.svg#insta"/>
												</svg>
											</a>
										</li>
									<?php endif; ?>
									<?php if(Yii::$app->settings->get('Settings.social_vk')): ?>
										<li class="common__item">
											<a href="<?php echo Yii::$app->settings->get('Settings.social_vk') ?>" class="common__link common__icon" target="_blank" rel="nofollow">
												<svg class="common__svg common__svg_vk">
													<use xlink:href="/img/sprite-sheet.svg#vk"/>
												</svg>
											</a>
										</li>
									<?php endif; ?>
									<?php if(Yii::$app->settings->get('Settings.social_viber')): ?>
										<li class="common__item">
											<a href="<?php echo Yii::$app->settings->get('Settings.social_viber') ?>" class="common__link common__icon" target="_blank" rel="nofollow">
												<svg class="common__svg common__svg_viber">
													<use xlink:href="/img/sprite-sheet.svg#viber"/>
												</svg>
											</a>
										</li>
									<?php endif; ?>
									<?php if(Yii::$app->settings->get('Settings.social_whatsapp')): ?>
										<li class="common__item">
											<a href="<?php echo Yii::$app->settings->get('Settings.social_whatsapp') ?>" class="common__link common__icon" target="_blank" rel="nofollow">
												<svg class="common__svg common__svg_watsapp">
													<use xlink:href="/img/sprite-sheet.svg#watsapp"/>
												</svg>
											</a>
										</li>
									<?php endif; ?>
								</ul>
							</div>
						</li>
						<li class="contacts__item">
							<div class="common">
								<span class="common__heading">Реквизиты</span>
								<?php echo Yii::$app->settings->get('Settings.rekvizit') ?>
							</div>
						</li>
						<li class="contacts__item">
							<div class="common">
                                <span class="common__heading">&nbsp;</span>
								<ul class="common__list">
									<li class="common__item">
										<a href="/feedback" class="common__link common__link_bb">Написать администрации</a>
									</li>
									<li class="common__item">
										<a href="/feedback/order" class="common__link common__link_bb">Написать в отдел заказов</a>
									</li>
									<li class="common__item">
										<a href="/feedback/kp" class="common__link common__link_bb">Коммерческое предложение</a>
									</li>
								</ul>
							</div>
						</li>
					</ul>
				</div>
				<div class="contacts-right">
					<div class="common">
						<span class="common__heading">Схема проезда</span>
						<?php echo Yii::$app->settings->get('Settings.schema') ?>
					</div>
                    <div class="yandex-map" id="map"></div>   
				</div>
			</div>
		</div>
	</div>
</div>