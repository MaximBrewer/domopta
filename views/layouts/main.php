<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\MainAsset;
use app\widgets\loginform\LoginForm;
use app\models\Menu;
use app\models\Cart;
use yii\widgets\ActiveForm;
use app\models\SearchForm;

$searchModel = new SearchForm();
$searchModel->load(Yii::$app->request->queryParams);
MainAsset::register($this);


if (!isset(Yii::$app->params['page'])) {
    Yii::$app->params['page'] = new app\models\Page();
    Yii::$app->params['page']->title = "Оптовый Комплекс \"Легкий Ветер\"";
    Yii::$app->params['page']->keywords = "Оптовый Комплекс \"Легкий Ветер\"";
    Yii::$app->params['page']->description = "Оптовый Комплекс \"Легкий Ветер\"";
}

if (Yii::$app->params['page']->title) {
    $this->title = Yii::$app->params['page']->title;
}
if (isset(Yii::$app->params['page']->keywords)) {
    $this->registerMetaTag(['name' => 'keywords', 'content' => Yii::$app->params['page']->keywords]);
}
if (isset(Yii::$app->params['page']->description)) {
    $this->registerMetaTag(['name' => 'description', 'content' => Yii::$app->params['page']->description]);
}

if (Yii::$app->session->hasFlash('login')) {
    $this->registerJS('alert("' . Yii::$app->session->getFlash('login') . '")');
}

$categories = \app\models\Category::find()->where('parent_id IS NULL')->orderBy(['position' => SORT_ASC])->all();

if (Yii::$app->user->isGuest) {
    $this->registerJsFile('/js/reg.js', ['depends' => \yii\web\JqueryAsset::class]);
}
$this->registerCssFile("@web/css/jquery.jgrowl.min.css", ['depends' => \yii\bootstrap\BootstrapAsset::class]);

$this->registerJsFile('@web/js/magnifier.js', ['depends' => \yii\web\JqueryAsset::class]);
$this->registerJsFile('@web/js/lightslider.js', ['depends' => \yii\web\JqueryAsset::class]);
$this->registerJsFile('@web/js/jquery.jgrowl.min.js', ['depends' => yii\web\JqueryAsset::class]);


?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="/img/favicon.png" />

    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <script src="/js/svg4everybody.js"></script>
    <script>
        svg4everybody();
    </script>
    <?php $this->head() ?>
</head>

<body>
    <!-- Yandex.Metrika counter -->
    <script type="text/javascript">
        var fired = false;

        function epprFu() {
            fired = true;
            setTimeout(function() {
                (function(m, e, t, r, i, k, a) {
                    m[i] = m[i] || function() {
                        (m[i].a = m[i].a || []).push(arguments)
                    };
                    m[i].l = 1 * new Date();
                    k = e.createElement(t), a = e.getElementsByTagName(t)[0], k.async = 1, k.src = r, a.parentNode.insertBefore(k, a)
                })
                (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");
                ym(74353687, "init", {
                    clickmap: true,
                    trackLinks: true,
                    accurateTrackBounce: true
                });
            }, 500);
        }
        document.addEventListener("touchstart", () => {
            fired || epprFu();
        });
        document.addEventListener("keydown", () => {
            fired || epprFu();
        });
        document.addEventListener("mousedown", () => {
            fired || epprFu();
        });
        document.addEventListener("mousemove", () => {
            fired || epprFu();
        });
        document.addEventListener("wheel", () => {
            fired || epprFu();
        });
        if (window.scrollY) {
            fired || epprFu();
        }
    </script>

    <noscript>
        <div><img src="https://mc.yandex.ru/watch/74353687" style="position:absolute; left:-9999px;" alt="" /></div>
    </noscript>
    <!-- /Yandex.Metrika counter -->
    <?php $this->beginBody() ?>
    <div id="preloader">
        <div class="spinner"></div>
    </div>
    <div class="wrapper">
        <header class="header" id="header">
            <div class="header-top" id="header-top">
                <div class="container container_fl-wr">
                    <div class="logo-header header__logo-header">
                        <a href="/" class="logo-header__icon">
                            <svg class="svg logo-header__svg logo-header__svg_logo1">
                                <use xlink:href="/img/sprite-sheet.svg#logo1" />
                            </svg>
                        </a>
                    </div>
                    <div class="text-header header__text-header">
                        <div class="text-header-top">Оптовый комплекс</div>
                        <div class="text-header-bottom">прямые поставки от производителя</div>
                    </div>
                    <div class="support-header header__support-header">
                        <a href="tel:<?php echo Yii::$app->settings->get('Settings.phone_call') ?>" class="support-header-top"><?php echo Yii::$app->settings->get('Settings.phone_call') ?></a>
                        <div class="support-header-bottom">Бесплатно по РФ</div>
                    </div>
                    <div class="contacts-header header__contacts-header">
                        <ul class="contacts-header__list">
                            <li class="contacts-header__item">
                                <a href="tel:<?php echo Yii::$app->settings->get('Settings.phone_admin') ?>" class="contacts-header__phone"><?php echo Yii::$app->settings->get('Settings.phone_admin') ?></a>
                            </li>
                            <li class="contacts-header__item">
                                <a href="tel:<?php echo Yii::$app->settings->get('Settings.phone') ?>" class="contacts-header__phone"><?php echo Yii::$app->settings->get('Settings.phone') ?></a>
                            </li>
                        </ul>
                        <a href="#" id="contacts-btn" class="contacts-header__btn contacts-header__icon icon-help">
                            <svg class="svg contacts-header__svg contacts-header__svg_comments">
                                <use xlink:href="/img/sprite-sheet.svg#comments" />
                            </svg>
                            <span class="help">
                                <span class="help__text">Контакты</span>
                            </span>
                        </a>
                    </div>
                    <div class="schedule-header header__schedule-header">
                        <div class="schedule-header-top"><?php echo Yii::$app->settings->get('Settings.time') ?></div>
                    </div>
                    <div class="header__reg-enter-header reg-enter-header">
                        <ul class="reg-enter-header__list">
                            <?php if (Yii::$app->user->isGuest) : ?>
                                <li class="reg-enter-header__item">
                                    <a href="#" id="reg" class="reg-enter-header__link">Регистрация</a>
                                </li>
                                <li class="reg-enter-header__item">
                                    <a href="#" id="enter" class="reg-enter-header__link">Войти</a>
                                </li>
                            <?php else : ?>
                                <?php if (Yii::$app->user->identity->profile->name == '') : ?>
                                    <li class="reg-enter-header__item">
                                        <a href="/reg/full?step=1" class="reg-enter-header__link">Регистрация</a>
                                    </li>
                                <?php else : ?>
                                    <li class="reg-enter-header__item">
                                        <a href="/cabinet" class="reg-enter-header__link">Кабинет</a>
                                    </li>
                                <?php endif; ?>
                                <li class="reg-enter-header__item">
                                    <a href="/site/logout" id="logout" class="reg-enter-header__link">Выход</a>
                                </li>
                            <?php endif; ?>
                        </ul>
                        <?php if (Yii::$app->user->isGuest) : ?>
                            <a href="#" id="enter-btn" class="reg-enter-header__btn reg-enter-header__icon icon-help">
                                <svg class="svg reg-enter-header__svg reg-enter-header__svg_user">
                                    <use xlink:href="/img/sprite-sheet.svg#user" />
                                </svg>
                                <span class="help">
                                    <span class="help__text">Войти</span>
                                </span>
                            </a>
                        <?php else : ?>
                            <?php if (!Yii::$app->user->identity->profile->type) : ?>
                                <a href="/reg/step1" class="reg-enter-header__btn reg-enter-header__icon icon-help">
                                    <svg class="svg reg-enter-header__svg reg-enter-header__svg_user">
                                        <use xlink:href="/img/sprite-sheet.svg#user" />
                                    </svg>
                                    <span class="help">
                                        <span class="help__text">Полная регистрация</span>
                                    </span>
                                </a>
                            <?php else : ?>
                                <a href="/cabinet" class="reg-enter-header__btn reg-enter-header__icon icon-help">
                                    <svg class="svg reg-enter-header__svg reg-enter-header__svg_user">
                                        <use xlink:href="/img/sprite-sheet.svg#user" />
                                    </svg>
                                    <span class="help">
                                        <span class="help__text">Кабинет</span>
                                    </span>
                                </a>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="header-bottom" id="header-bottom">
                <div class="container container_fl-wr">
                    <nav class="nav header__nav">
                        <ul class="nav__list">
                            <?php $menu = Menu::find()->orderBy('order')->all(); ?>
                            <?php foreach ($menu as $item) : ?>
                                <?php if ($item->page->menu_type == 0) : ?>
                                    <li class="nav__item">
                                        <a href="<?php echo $item->page->slug; ?>" class="nav__link"><span><?php echo $item->page->name; ?></span></a>
                                    </li>
                                <?php else : ?>
                                    <li class="nav__item">
                                        <div class="drop-header header__drop-header">
                                            <span class="nav__link" style="cursor:pointer"><span><?php echo $item->page->name; ?></span></span>
                                            <ul class="drop-header__list">
                                                <?php foreach ($categories as $category) : ?>
                                                    <li class="drop-header__item">
                                                        <div class="common">
                                                            <a href="<?php echo $category->slug ?>" class="common__heading"><?php echo $category->name ?></a>
                                                            <?php $subcats = $category->getChildren() ?>
                                                            <?php if ($subcats) : ?>
                                                                <ul class="common__list">
                                                                    <?php foreach ($subcats as $subcat) : ?>
                                                                        <li class="common__item">
                                                                            <a href="<?php echo $subcat->slug ?>" class="common__link"><?php echo $subcat->name ?></a>
                                                                        </li>
                                                                    <?php endforeach; ?>
                                                                </ul>
                                                            <?php endif; ?>
                                                        </div>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                            <li class="nav__item">
                                <a href="/contacts" class="nav__link"><span>Контакты</span></a>
                            </li>
                        </ul>
                        <a href="#" class="nav__btn nav__icon" id="nav-btn">
                            <svg class="svg nav__svg nav__svg_gamburg">
                                <use xlink:href="/img/sprite-sheet.svg#gamburg" />
                            </svg>
                        </a>
                    </nav>
                    <div class="search-header header__search-header">
                        <div class="search-header-form">
                            <form action="<?php echo \yii\helpers\Url::to('/search') ?>">
                                <?php echo Html::activeTextInput($searchModel, 'text', ['class' => 'search-header-input', 'placeholder' => 'Введите товар']) ?>
                                <button class="search-header__btn">
                                    <svg class="svg search-header__svg search-header__svg_search">
                                        <use xlink:href="/img/sprite-sheet.svg#search" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                        <a href="#" id="search-btn" class="search-header__btn search-header__btn_phone">
                            <svg class="svg search-header__svg search-header__svg_search">
                                <use xlink:href="/img/sprite-sheet.svg#search" />
                            </svg>
                        </a>
                    </div>
                    <div class="liked-header header__liked-header">
                        <a href="/favorites" class="liked-header__btn liked-header__icon icon-help" <?php if (Yii::$app->user->isGuest) : ?> onclick="$('#enter').click(); return false;" <?php endif; ?>>
                            <svg class="liked-header__svg liked-header__svg_heart1">
                                <use xlink:href="/img/sprite-sheet.svg#heart1" />
                            </svg>
                            <svg class="liked-header__svg liked-header__svg_heart2">
                                <use xlink:href="/img/sprite-sheet.svg#heart2" />
                            </svg>
                            <span class="help">
                                <span class="help__text">Избранное</span>
                            </span>
                            <?php if (Yii::$app->user->isGuest) : ?>
                                <div class="liked-header-counter"></div>
                            <?php else : ?>
                                <?php $favorites = Yii::$app->user->identity->getFavoritesAmount(); ?>
                                <div class="liked-header-counter<?php echo $favorites > 99 ? " lhcsf" : ""; ?>"><?php echo $favorites ?></div>
                            <?php endif; ?>
                        </a>
                    </div>
                    <a href="/cart" id="cart-btn" class="cart-header header__cart-header">
                        <span class="cart-header__btn cart-header__icon icon-help">
                            <svg class="cart-header__svg cart-header__svg_basket1">
                                <use xlink:href="/img/sprite-sheet.svg#basket1" />
                            </svg>
                            <svg class="cart-header__svg cart-header__svg_basket2">
                                <use xlink:href="/img/sprite-sheet.svg#basket2" />
                            </svg>
                            <span class="help">
                                <span class="help__text">Корзина</span>
                            </span>
                        </span>
                        <div class="cart-header__info">
                            <?php $cart = Cart::getAmount(); ?>
                            <div class="cart-header__total">Всего: <span id="cart_amount"><?php echo $cart['amount'] ?></span> шт.</div>
                            <div class="cart-header__amount">Сумма: <span id="cart_sum"><?php echo $cart['sum'] ?></span> ₽</div>
                            <!--                            <div class="cart-header__total">Всего: <span id="cart_amount">408</span> шт.</div>-->
                            <!--                            <div class="cart-header__amount">Сумма: <span id="cart_sum">281555,00</span></div>-->
                        </div>
                    </a>
                </div>
            </div>
        </header>
        <div class="main">
            <?php echo $content; ?>

            <div class="arrows">
                <ul class="arrows__list">
                    <li class="arrows__item">
                        <a href="#" class="arrows__link arrows__icon to-top">
                            <svg class="arrows__svg arrows__svg_arrow1-up">
                                <use xlink:href="/img/sprite-sheet.svg#arrow1-up" />
                            </svg>
                        </a>
                    </li>
                    <li class="arrows__item">
                        <a href="#bottom-anchor" class="arrows__link arrows__icon to-down">
                            <svg class="arrows__svg arrows__svg_arrow1-dn">
                                <use xlink:href="/img/sprite-sheet.svg#arrow1-dn" />
                            </svg>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <footer class="footer">
            <div class="container container_dir-col">
                <div class="footer-top">
                    <ul class="footer__list">
                        <li class="footer__item">
                            <div class="common footer__common">
                                <a href="#" class="common__heading">Информация</a>
                                <ul class="common__list">
                                    <li class="common__item">
                                        <a href="/uslovia-raboty" class="common__link">Условия работы</a>
                                    </li>
                                    <li class="common__item">
                                        <a href="/faq" class="common__link">Вопросы и ответы</a>
                                    </li>
                                    <li class="common__item">
                                        <a href="/dogovor" class="common__link">Заключение договора</a>
                                    </li>
                                    <li class="common__item">
                                        <a href="/discount" class="common__link">Система скидок</a>
                                    </li>
                                    <li class="common__item">
                                        <a href="/dostavka" class="common__link">Доставка товара</a>
                                    </li>
                                    <li class="common__item">
                                        <a href="/return-product" class="common__link">Возврат товара</a>
                                    </li>
                                    <li class="common__item">
                                        <a href="/detect-size" class="common__link">Как определить размер</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="footer__item">
                            <div class="common footer__common">
                                <a href="/cabinet" class="common__heading">Личный кабинет</a>
                                <ul class="common__list">
                                    <li class="common__item">
                                        <a href="/cabinet" class="common__link">Мои данные</a>
                                    </li>
                                    <li class="common__item">
                                        <a href="/history" class="common__link">История заказов</a>
                                    </li>
                                    <li class="common__item">
                                        <a href="/favorites" class="common__link">Избранное</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="footer__item">
                            <div class="common footer__common">
                                <a href="#" class="common__heading">О компании</a>
                                <ul class="common__list">
                                    <li class="common__item">
                                        <a href="/o-nas" class="common__link">О нас</a>
                                    </li>
                                    <li class="common__item">
                                        <a href="/sertifikaty" class="common__link">Сертификаты</a>
                                    </li>
                                    <li class="common__item">
                                        <a href="/tovarnye-znaki" class="common__link">Товарные знаки</a>
                                    </li>
                                    <li class="common__item">
                                        <a href="/news" class="common__link">Новости</a>
                                    </li>
                                    <li class="common__item">
                                        <a href="/contacts" class="common__link">Контакты</a>
                                    </li>
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
                        <li class="footer__item">
                            <div class="common footer__common">
                                <a href="#" class="common__heading">Телефоны</a>
                                <ul class="common__list common__list_show">
                                    <li class="common__item common__item_flex">
                                        <div class="common__icon">
                                            <svg class="common__svg common__svg_comments">
                                                <use xlink:href="/img/sprite-sheet.svg#comments" />
                                            </svg>
                                        </div>
                                        <ul class="footer-contacts__list">
                                            <li class="footer-contacts__item">
                                                <a href="tel:<?php echo Yii::$app->settings->get('Settings.phone_call') ?>" class="support-header-top"><?php echo Yii::$app->settings->get('Settings.phone_call') ?></a>
                                                <div class="support-header-bottom">Бесплатно по РФ</div>
                                            </li>
                                            <li class="footer-contacts__item">
                                                <a href="tel:<?php echo Yii::$app->settings->get('Settings.phone_order') ?>" class="support-header-top"><?php echo Yii::$app->settings->get('Settings.phone_order') ?></a>
                                                <div class="support-header-bottom">АДМИНИСТРАЦИЯ</div>
                                            </li>
                                            <li class="footer-contacts__item">
                                                <a href="tel:<?php echo Yii::$app->settings->get('Settings.phone_admin') ?>" class="support-header-top"><?php echo Yii::$app->settings->get('Settings.phone_admin') ?></a>
                                                <div class="support-header-bottom">КОНСУЛЬТАЦИЯ</div>
                                            </li>
                                            <li class="footer-contacts__item">
                                                <a href="tel:<?php echo Yii::$app->settings->get('Settings.phone') ?>" class="support-header-top"><?php echo Yii::$app->settings->get('Settings.phone') ?></a>
                                                <div class="support-header-bottom">ОТДЕЛ ЗАКАЗОВ</div>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="footer__item">
                            <div class="common footer__common">
                                <a href="#" class="common__heading">Адрес</a>
                                <ul class="common__list footer_common__list">
                                    <li class="common__item common__item_flex common__item_mb">
                                        <div class="common__icon">
                                            <svg class="svg common__svg common__svg_place">
                                                <use xlink:href="/img/sprite-sheet.svg#place" />
                                            </svg>
                                        </div>
                                        <div class="text-header footer__text-header">
                                            <div class="text-header-top">ОПТОВЫЙ КОМПЛЕКС “ЛЕГКИЙ ВЕТЕР”</div>
                                            <div class="text-header-bottom"><?php echo Yii::$app->settings->get('Settings.addresses') ?></div>
                                        </div>
                                    </li>
                                    <li class="common__item common__item_flex">
                                        <div class="common__icon">
                                            <svg class="svg common__svg common__svg_time">
                                                <use xlink:href="/img/sprite-sheet.svg#time" />
                                            </svg>
                                        </div>
                                        <div class="fotter-schedule">
                                            <div class="fotter-schedule-top"><?php echo Yii::$app->settings->get('Settings.time') ?></div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="footer__item">
                            <div class="common footer__common">
                                <a href="#" class="common__heading">Мы в социальных сетях</a>
                                <ul class="common__list common__list_flex common__list_pt">
                                    <?php if (Yii::$app->settings->get('Settings.social_instagram')) : ?>
                                        <li class="common__item">
                                            <a href="<?php echo Yii::$app->settings->get('Settings.social_instagram') ?>" class="common__link common__icon" target="_blank" rel="nofollow">
                                                <svg class="common__svg common__svg_insta">
                                                    <use xlink:href="/img/sprite-sheet.svg#insta" />
                                                </svg>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if (Yii::$app->settings->get('Settings.social_vk')) : ?>
                                        <li class="common__item">
                                            <a href="<?php echo Yii::$app->settings->get('Settings.social_vk') ?>" class="common__link common__icon" target="_blank" rel="nofollow">
                                                <svg class="common__svg common__svg_vk">
                                                    <use xlink:href="/img/sprite-sheet.svg#vk" />
                                                </svg>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if (Yii::$app->settings->get('Settings.social_viber')) : ?>
                                        <li class="common__item">
                                            <a href="<?php echo Yii::$app->settings->get('Settings.social_viber') ?>" class="common__link common__icon" target="_blank" rel="nofollow">
                                                <svg class="common__svg common__svg_viber">
                                                    <use xlink:href="/img/sprite-sheet.svg#viber" />
                                                </svg>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if (Yii::$app->settings->get('Settings.social_whatsapp')) : ?>
                                        <li class="common__item">
                                            <a href="<?php echo Yii::$app->settings->get('Settings.social_whatsapp') ?>" class="common__link common__icon" target="_blank" rel="nofollow">
                                                <svg class="common__svg common__svg_watsapp">
                                                    <use xlink:href="/img/sprite-sheet.svg#watsapp" />
                                                </svg>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="footer-bottom" id="bottom-anchor">
                    <div class="footer-left">
                        <div class="logo-footer footer__logo-footer">
                            <ul class="logo-footer__list">
                                <li class="logo-footer__item">
                                    <div class="logo-footer__icon">
                                        <svg class="logo-footer__svg logo-footer__svg_logo logo-footer__svg_logo2">
                                            <use xlink:href="/img/sprite-sheet.svg#logo2" />
                                        </svg>
                                    </div>
                                </li>
                                <li class="logo-footer__item">
                                    <div class="logo-footer__icon">
                                        <svg class="logo-footer__svg logo-footer__svg_logo">
                                            <use xlink:href="/img/sprite-sheet.svg#logo1" />
                                        </svg>
                                    </div>
                                </li>
                                <li class="logo-footer__item">
                                    <div class="logo-footer__icon">
                                        <svg class="logo-footer__svg logo-footer__svg_logo" viewBox="0 0 835 330">
                                            <g transform="translate(0.000000,330.000000) scale(0.100000,-0.100000)" fill="#000000" stroke="none">
                                                <path d="M10 1755 l0 -1545 63 0 c175 0 445 38 675 95 359 88 613 212 778 379 257 260 222 581 -85 789 -136 92 -277 151 -736 312 -227 79 -411 172 -484 244 -101 99 -146 230 -122 356 56 305 297 514 777 674 217 72 345 95 529 95 269 -1 434 -62 503 -188 29 -52 22 -173 -15 -273 -80 -211 -213 -370 -305 -361 -55 5 -48 33 37 139 115 142 152 240 126 335 -58 217 -576 215 -1094 -4 -365 -155 -486 -351 -344 -558 93 -135 254 -220 707 -372 457 -154 550 -200 682 -340 214 -228 210 -530 -12 -806 -275 -341 -827 -619 -1413 -711 -70 -11 44 -13 811 -14 l892 -1 0 1650 0 1650 -985 0 -985 0 0 -1545z" />
                                                <path d="M8136 1890 c-68 -21 -110 -89 -104 -165 5 -62 29 -98 84 -125 51 -25 94 -25 143 0 133 67 94 276 -54 294 -22 3 -53 1 -69 -4z m114 -45 c42 -22 63 -68 57 -124 -13 -114 -167 -148 -227 -49 -37 60 -17 142 42 174 31 18 93 17 128 -1z" />
                                                <path d="M8120 1740 c0 -73 3 -90 15 -90 10 0 15 11 15 35 0 48 31 48 62 0 13 -19 31 -35 41 -35 22 0 21 8 -2 44 -18 27 -18 31 -4 53 32 48 -9 83 -98 83 l-29 0 0 -90z" />
                                                <path d="M4670 1675 c-174 -49 -264 -151 -264 -300 0 -148 61 -216 308 -349 196 -105 250 -153 262 -231 23 -154 -132 -244 -346 -201 -87 18 -180 54 -212 83 -17 15 -18 12 -18 -69 l0 -86 43 -17 c149 -60 394 -58 515 4 106 54 154 127 160 245 9 170 -57 249 -328 391 -198 104 -240 148 -240 248 0 60 32 105 98 139 96 48 254 46 370 -7 l52 -24 0 75 0 75 -37 16 c-55 23 -289 28 -363 8z" />
                                                <path d="M2280 1075 l0 -595 315 0 315 0 0 60 0 60 -245 0 -245 0 0 210 0 210 215 0 215 0 0 65 0 65 -215 0 -215 0 0 200 0 200 230 0 230 0 0 60 0 60 -300 0 -300 0 0 -595z" />
                                                <path d="M3160 1075 l0 -595 70 0 70 0 -2 511 c-2 344 0 505 7 494 6 -10 152 -239 326 -509 l317 -491 86 -3 86 -3 0 596 0 595 -71 0 -71 0 4 -504 3 -505 -30 49 c-16 26 -160 253 -320 504 l-290 455 -92 1 -93 0 0 -595z" />
                                                <path d="M5372 1228 c4 -488 4 -488 70 -598 40 -66 111 -122 187 -147 76 -24 294 -24 361 1 149 55 233 172 259 360 6 44 11 239 11 452 l0 374 -69 0 -70 0 -3 -427 c-3 -411 -4 -430 -25 -481 -32 -78 -66 -117 -129 -148 -48 -23 -70 -28 -138 -28 -148 0 -241 55 -288 173 -22 55 -23 66 -26 484 l-3 427 -70 0 -70 0 3 -442z" />
                                                <path d="M6580 1075 l0 -595 315 0 315 0 0 60 0 60 -245 0 -245 0 0 210 0 210 215 0 215 0 0 65 0 65 -215 0 -215 0 0 200 0 200 230 0 230 0 0 60 0 60 -300 0 -300 0 0 -595z" />
                                                <path d="M7540 1075 l0 -595 305 0 305 0 0 60 0 60 -237 2 -238 3 -3 533 -2 532 -65 0 -65 0 0 -595z" />
                                            </g>
                                        </svg>
                                    </div>
                                </li>
                                <li class="logo-footer__item">
                                    <div class="logo-footer__icon">
                                        <svg class="logo-footer__svg logo-footer__svg_logo">
                                            <use xlink:href="/img/sprite-sheet.svg#logo4" />
                                        </svg>
                                    </div>
                                </li>
                            </ul>
                            <div class="footer__copy">© Все права защищены</div>
                        </div>
                    </div>
                    <div class="footer-right">
                        <div class="footer__text"><?php echo Yii::$app->settings->get('Settings.footer') ?></div>
                    </div>
                    <div class="footer-end">
                        <ul class="footer-end__list">
                            <li class="footer-end__item">
                                <a href="/politika-konfidencialnosti" class="footer-end__link">Политика конфиденциальности</a>
                            </li>
                            <li class="footer-end__item">
                                <a href="/polzovatelskoe-soglasenie" class="footer-end__link">Пользовательское соглашение</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
        <div class="look-pop">
            <div class="container container_pop-big">
            </div>
        </div>
        <?php if (Yii::$app->user->isGuest) : ?>
            <div class="reg-pop">

            </div>
            <div class="log-pop">

            </div>
        <?php else : ?>
            <div class="log-pop">

            </div>
        <?php endif; ?>

        <div class="nav-pop">
            <div class="container container_pop-small">
                <div class="nav-pop-inner">
                    <nav class="nav">
                        <ul class="nav__list">
                            <?php foreach ($menu as $item) : ?>
                                <?php if ($item->page->menu_type == 0) : ?>
                                    <li class="nav__item">
                                        <a href="<?php echo $item->page->slug; ?>" class="nav__link"><span><?php echo $item->page->name; ?></span></a>
                                    </li>
                                <?php else : ?>
                                    <li class="nav__item">
                                        <div class="drop-content content-btn__drop-content drop-content_pop">
                                            <a href="<?php echo $item->page->slug; ?>" id="cat" class="nav__link"><span><?php echo $item->page->name; ?></span></a>
                                        </div>
                                        <ul class="category__list category__list_pop">
                                            <?php foreach ($categories as $category) : ?>
                                                <li class="category__item">
                                                    <a href="<?php echo $category->slug ?>" class="category__link">
                                                        <span class="category__icon">
                                                            <svg class="svg category__svg category__svg_arrow2-right">
                                                                <use xlink:href="/img/sprite-sheet.svg#arrow2-right" />
                                                            </svg>
                                                        </span>
                                                        <span class="category__text"><?php echo $category->name ?></span>
                                                    </a>
                                                    <?php $subcats = $category->getChildren() ?>
                                                    <?php if ($subcats) : ?>
                                                        <div class="subcategory category__subcategory">
                                                            <ul class="subcategory__list">
                                                                <?php foreach ($subcats as $subcat) : ?>
                                                                    <li class="subcategory__item">
                                                                        <a href="<?php echo $subcat->slug ?>" class="subcategory__link"><?php echo $subcat->name ?></a>
                                                                    </li>
                                                                <?php endforeach; ?>
                                                            </ul>
                                                        </div>
                                                    <?php endif; ?>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                            <li class="nav__item">
                                <a href="/contacts" class="nav__link"><span>Контакты</span></a>
                            </li>
                            <?php if (Yii::$app->user->isGuest) : ?>
                                <li class="nav__item">
                                    <a href="#" id="reg" class="nav__link">Регистрация</a>
                                </li>
                                <li class="nav__item">
                                    <a href="#" id="enter" class="nav__link">Войти</a>
                                </li>
                            <?php else : ?>
                                <?php if (Yii::$app->user->identity->profile->name == '') : ?>
                                    <li class="nav__item">
                                        <a href="/reg/full?step=1" class="nav__link">Регистрация</a>
                                    </li>
                                <?php else : ?>
                                    <li class="nav__item">
                                        <a href="/cabinet" class="nav__link">Кабинет</a>
                                    </li>
                                <?php endif; ?>
                                <li class="nav__item">
                                    <a href="/site/logout" id="logout" class="nav__link">Выход</a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                    <a href="#" id="esc" class="esc">
                        <div class="esc__icon esc__icon_cross1">
                            <svg class="svg esc__svg esc__svg_cross1">
                                <use xlink:href="/img/sprite-sheet.svg#cross1" />
                            </svg>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="contacts-pop">
            <div class="container container_pop-small">
                <div class="contacts-pop-inner">
                    <div class="contacts-pop__title">Контакты</div>
                    <ul class="contacts-pop__list">
                        <li class="contacts-pop__item">
                            <div class="common">
                                <a href="#" class="common__heading">Телефоны</a>
                                <ul class="common__list">
                                    <li class="common__item common__item_flex">
                                        <div class="common__icon">
                                            <svg class="common__svg common__svg_comments">
                                                <use xlink:href="/img/sprite-sheet.svg#comments" />
                                            </svg>
                                        </div>
                                        <ul class="footer-contacts__list">
                                            <li class="footer-contacts__item">
                                                <a href="tel:<?php echo Yii::$app->settings->get('Settings.phone_call') ?>" class="support-header-top"><?php echo Yii::$app->settings->get('Settings.phone_call') ?></a>
                                                <div class="support-header-bottom">Бесплатно по РФ</div>
                                            </li>
                                            <li class="footer-contacts__item">
                                                <a href="tel:<?php echo Yii::$app->settings->get('Settings.phone_order') ?>" class="support-header-top"><?php echo Yii::$app->settings->get('Settings.phone_order') ?></a>
                                                <div class="support-header-bottom">АДМИНИСТРАЦИЯ</div>
                                            </li>
                                            <li class="footer-contacts__item">
                                                <a href="tel:<?php echo Yii::$app->settings->get('Settings.phone_admin') ?>" class="support-header-top"><?php echo Yii::$app->settings->get('Settings.phone_admin') ?></a>
                                                <div class="support-header-bottom">АДМИНИСТРАЦИЯ</div>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="contacts-pop__item">
                            <div class="common">
                                <a href="#" class="common__heading">Адрес</a>
                                <ul class="common__list">
                                    <li class="common__item common__item_flex common__item_mb">
                                        <div class="common__icon">
                                            <svg class="svg common__svg common__svg_place">
                                                <use xlink:href="/img/sprite-sheet.svg#place" />
                                            </svg>
                                        </div>
                                        <div class="text-header footer__text-header">
                                            <div class="text-header-top">ОПТОВЫЙ КОМПЛЕКС “ЛЕГКИЙ ВЕТЕР”</div>
                                            <div class="text-header-bottom">Республика Крым <br> г. Симферополь, ул. Крылова, 123</div>
                                        </div>
                                    </li>
                                    <li class="common__item common__item_flex">
                                        <div class="common__icon">
                                            <svg class="svg common__svg common__svg_time">
                                                <use xlink:href="/img/sprite-sheet.svg#time" />
                                            </svg>
                                        </div>
                                        <div class="fotter-schedule">
                                            <div class="fotter-schedule-top">Пн-Сб с 9:00 до 18:00 </div>
                                            <div class="fotter-schedule-bottom">ВОСКРЕСЕНЬЕ ВЫХОДНОЙ</div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                    <a href="#" id="esc" class="esc">
                        <div class="esc__icon esc__icon_cross1">
                            <svg class="svg esc__svg esc__svg_cross1">
                                <use xlink:href="/img/sprite-sheet.svg#cross1" />
                            </svg>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="search-pop">
            <div class="container container_pop-small">
                <div class="search-pop-inner">
                    <div class="search-header">
                        <div class="search-pop__title">Поиск</div>
                        <div class="search-header-form">
                            <form action="/search">
                                <input type="text" placeholder="ВВЕДИТЕ ТОВАР" name="SearchForm[text]" class="search-header-input">
                                <button class="search-header__btn" type="submit">
                                    <svg class="svg search-header__svg search-header__svg_search">
                                        <use xlink:href="/img/sprite-sheet.svg#search" />
                                    </svg>
                                </button>
                            </form>
                        </div>
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
        </div>
    </div>

    <?php $this->endBody() ?>



</body>

</html>
<?php $this->endPage() ?>