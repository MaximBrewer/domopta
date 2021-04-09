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
			<div class="contacts-middle">
				<div class="grid-cols-3 gap-12 lg:grid">
					<div class="common">
						<span class="common__heading mobile-open">Телефоны</span>
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
					<div class="common">
						<span class="common__heading mobile-open">Адрес</span>
						<ul class="common__list common__list_show">
							<li class="common__item common__item_flex">
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
						</ul>
					</div>
					<div class="common">
						<span class="common__heading mobile-open">Режим работы</span>
						<ul class="common__list common__list_show">
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
				</div>
			</div>
			<div class="contacts-bottom pb-4">
				<div class="grid-cols-3 gap-12 lg:grid w-full">
					<div class="common">
						<span class="common__heading mobile-open">Схема проезда</span>
						<?php echo Yii::$app->settings->get('Settings.schema') ?>
					</div>
					<div class="col-span-2">
						<div class="yandex-map" id="map"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>