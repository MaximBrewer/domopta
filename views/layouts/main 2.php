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
if(Yii::$app->params['page']->title){
    $this->title = Yii::$app->params['page']->title;
}
if(isset(Yii::$app->params['page']->keywords)){
    $this->registerMetaTag(['name' => 'keywords', 'content' => Yii::$app->params['page']->keywords]);
}
if(isset(Yii::$app->params['page']->description)){
    $this->registerMetaTag(['name' => 'description', 'content' => Yii::$app->params['page']->description]);
}

if(Yii::$app->session->hasFlash('login')){
    $this->registerJS('alert("'.Yii::$app->session->getFlash('login').'")');
}

$categories = \app\models\Category::find()->where('parent_id IS NULL')->orderBy(['position' => SORT_ASC])->all();

if(Yii::$app->user->isGuest){
	$this->registerJsFile('/js/reg.js',['depends' => \yii\web\JqueryAsset::className()]);
}

$this->registerJsFile('/js/magnifier.js',['depends' => \yii\web\JqueryAsset::className()]);
$this->registerJsFile('/js/lightslider.js',['depends' => \yii\web\JqueryAsset::className()]);

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
        <script>svg4everybody();</script>
        <?php $this->head() ?>
    </head>
    <body>
    <?php $this->beginBody() ?>
    <div id="preloader" >
        <div class="spinner"></div>
    </div>
    <div class="wrapper">
        <header class="header" id="header">
            <div class="header-top" id="header-top">
                <div class="container container_fl-wr">
                    <div class="logo-header header__logo-header">
                        <a href="/" class="logo-header__icon">
                            <svg class="svg logo-header__svg logo-header__svg_logo1">
                                <use xlink:href="/img/sprite-sheet.svg#logo1"/>
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
                                <use xlink:href="/img/sprite-sheet.svg#comments"/>
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
                            <?php if(Yii::$app->user->isGuest): ?>
                            <li class="reg-enter-header__item">
                                <a href="#" id="reg" class="reg-enter-header__link">Регистрация</a>
                            </li>
                            <li class="reg-enter-header__item">
                                <a href="#" id="enter" class="reg-enter-header__link">Войти</a>
                            </li>
                            <?php else: ?>
                                <?php if(Yii::$app->user->identity->profile->name == ''): ?>
                                    <li class="reg-enter-header__item">
                                        <a href="/reg/full" class="reg-enter-header__link">Регистрация</a>
                                    </li>
                                <?php else: ?>
                                <li class="reg-enter-header__item">
                                    <a href="/cabinet" class="reg-enter-header__link">Кабинет</a>
                                </li>
                                <?php endif; ?>
                                <li class="reg-enter-header__item">
                                    <a href="/site/logout" id="logout" class="reg-enter-header__link">Выход</a>
                                </li>
                            <?php endif; ?>
                        </ul>
                        <?php if(Yii::$app->user->isGuest): ?>
                        <a href="#" id="enter-btn" class="reg-enter-header__btn reg-enter-header__icon icon-help">
                            <svg class="svg reg-enter-header__svg reg-enter-header__svg_user">
                                <use xlink:href="/img/sprite-sheet.svg#user"/>
                            </svg>
                            <span class="help">
                                <span class="help__text">Войти</span>
                            </span>
                        </a>
                        <?php else: ?>
                            <?php if(Yii::$app->user->identity->profile->name == ''): ?>
                                <a href="/reg/full" class="reg-enter-header__btn reg-enter-header__icon icon-help">
                                    <svg class="svg reg-enter-header__svg reg-enter-header__svg_user">
                                        <use xlink:href="/img/sprite-sheet.svg#user"/>
                                    </svg>
                                    <span class="help">
                                        <span class="help__text">Полная регистрация</span>
                                    </span>
                                </a>
                            <?php else: ?>
                                <a href="/cabinet"  class="reg-enter-header__btn reg-enter-header__icon icon-help">
                                    <svg class="svg reg-enter-header__svg reg-enter-header__svg_user">
                                        <use xlink:href="/img/sprite-sheet.svg#user"/>
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
	                        <?php foreach ($menu as $item): ?>
                                <?php if($item->page->menu_type == 0): ?>
                                <li class="nav__item">
                                    <a href="<?php echo $item->page->slug; ?>" class="nav__link"><span><?php echo $item->page->name; ?></span></a>
                                </li>
                                <?php else: ?>
                                    <li class="nav__item">
                                        <div class="drop-header header__drop-header">
                                            <span class="nav__link" style="cursor:pointer"><span><?php echo $item->page->name; ?></span></span>
                                            <ul class="drop-header__list">
						                        <?php foreach ($categories as $category): ?>
                                                    <li class="drop-header__item">
                                                        <div class="common">
                                                            <a href="<?php echo $category->slug ?>" class="common__heading"><?php echo $category->name ?></a>
									                        <?php $subcats = $category->getChildren() ?>
									                        <?php if($subcats): ?>
                                                                <ul class="common__list">
											                        <?php foreach ($subcats as $subcat): ?>
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
                                <use xlink:href="/img/sprite-sheet.svg#gamburg"/>
                            </svg>
                        </a>
                    </nav>
                    <div class="search-header header__search-header">
                        <div class="search-header-form">
                            <form action="<?php echo \yii\helpers\Url::to('/search') ?>">
                                <?php echo Html::activeTextInput($searchModel, 'text', ['class' => 'search-header-input', 'placeholder' => 'Введите товар']) ?>
                                <button class="search-header__btn">
                                    <svg class="svg search-header__svg search-header__svg_search">
                                        <use xlink:href="/img/sprite-sheet.svg#search"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                        <a href="#" id="search-btn" class="search-header__btn search-header__btn_phone">
                            <svg class="svg search-header__svg search-header__svg_search">
                                <use xlink:href="/img/sprite-sheet.svg#search"/>
                            </svg>
                        </a>
                    </div>
                    <div class="liked-header header__liked-header">
                        <a href="/favorites" class="liked-header__btn liked-header__icon icon-help" <?php if (Yii::$app->user->isGuest): ?> onclick="$('#enter').click(); return false;" <?php endif; ?>>
                            <svg class="liked-header__svg liked-header__svg_heart1">
                                <use xlink:href="/img/sprite-sheet.svg#heart1"/>
                            </svg>
                            <svg class="liked-header__svg liked-header__svg_heart2">
                                <use xlink:href="/img/sprite-sheet.svg#heart2"/>
                            </svg>
                            <span class="help">
                                <span class="help__text">Избранное</span>
                            </span>
                        </a>
                    </div>

                    <a href="/cart" id="cart-btn" class="cart-header header__cart-header">
                        <span class="cart-header__btn cart-header__icon icon-help">
                            <svg class="cart-header__svg cart-header__svg_basket1">
                                <use xlink:href="/img/sprite-sheet.svg#basket1"/>
                            </svg>
                            <svg class="cart-header__svg cart-header__svg_basket2">
                                <use xlink:href="/img/sprite-sheet.svg#basket2"/>
                            </svg>
                            <span class="help">
                                <span class="help__text">Корзина</span>
                            </span>
                        </span>
                        <div class="cart-header__info">
	                        <?php $cart = Cart::getAmount(); ?>
                            <div class="cart-header__total">Всего: <span id="cart_amount"><?php echo $cart['amount'] ?></span> шт.</div>
                            <div class="cart-header__amount">Сумма: <span id="cart_sum"><?php echo $cart['sum'] ?></span></div>
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
                                <use xlink:href="/img/sprite-sheet.svg#arrow1-up"/>
                            </svg>
                        </a>
                    </li>
                    <li class="arrows__item">
                        <a href="#bottom-anchor" class="arrows__link arrows__icon to-down">
                            <svg class="arrows__svg arrows__svg_arrow1-dn">
                                <use xlink:href="/img/sprite-sheet.svg#arrow1-dn"/>
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
                                <a href="#" class="common__heading">Свяжитесь с нами</a>
                                <ul class="common__list common__list_show">
                                    <li class="common__item common__item_flex">
                                        <div class="common__icon">
                                            <svg class="common__svg common__svg_comments">
                                                <use xlink:href="/img/sprite-sheet.svg#comments"/>
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
                                <ul class="common__list">
                                    <li class="common__item common__item_flex common__item_mb">
                                        <div class="common__icon">
                                            <svg class="svg common__svg common__svg_place">
                                                <use xlink:href="/img/sprite-sheet.svg#place"/>
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
                                                <use xlink:href="/img/sprite-sheet.svg#time"/>
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
                    </ul>
                </div>
                <div class="footer-bottom" id="bottom-anchor">
                    <div class="footer-left">
                        <div class="logo-footer footer__logo-footer">
                            <ul class="logo-footer__list">
                                <li class="logo-footer__item">
                                    <div class="logo-footer__icon">
                                        <svg class="logo-footer__svg logo-footer__svg_logo">
                                            <use xlink:href="/img/sprite-sheet.svg#logo1"/>
                                        </svg>
                                    </div>
                                </li>
                                <li class="logo-footer__item">
                                    <div class="logo-footer__icon">
                                        <svg class="logo-footer__svg logo-footer__svg_logo logo-footer__svg_logo2">
                                            <use xlink:href="/img/sprite-sheet.svg#logo2"/>
                                        </svg>
                                    </div>
                                </li>
                                <li class="logo-footer__item">
                                    <div class="logo-footer__icon">
                                        <svg class="logo-footer__svg logo-footer__svg_logo">
                                            <use xlink:href="/img/sprite-sheet.svg#logo3"/>
                                        </svg>
                                    </div>
                                </li>
                                <li class="logo-footer__item">
                                    <div class="logo-footer__icon">
                                        <svg class="logo-footer__svg logo-footer__svg_logo">
                                            <use xlink:href="/img/sprite-sheet.svg#logo4"/>
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
        <?php if(Yii::$app->user->isGuest): ?>
        <div class="reg-pop">

        </div>
        <div class="log-pop">

        </div>
        <?php else: ?>
            <div class="log-pop">

            </div>
        <?php endif; ?>

        <div class="nav-pop">
            <div class="container container_pop-small">
                <div class="nav-pop-inner">
                    <nav class="nav">
                        <ul class="nav__list">
                            <?php foreach ($menu as $item): ?>
                            <?php if($item->page->menu_type == 0): ?>
                                <li class="nav__item">
                                    <a href="<?php echo $item->page->slug; ?>" class="nav__link"><span><?php echo $item->page->name; ?></span></a>
                                </li>
                                <?php else: ?>
                                    <li class="nav__item">
                                        <div class="drop-content content-btn__drop-content drop-content_pop">
                                            <a href="<?php echo $item->page->slug; ?>" id="cat" class="nav__link"><span><?php echo $item->page->name; ?></span></a>
                                        </div>
                                        <ul class="category__list category__list_pop">
                                            <?php foreach ($categories as $category): ?>
                                                <li class="category__item">
                                                    <a href="<?php echo $category->slug ?>" class="category__link">
                                                        <span class="category__icon">
                                                            <svg class="svg category__svg category__svg_arrow2-right">
                                                                <use xlink:href="/img/sprite-sheet.svg#arrow2-right"/>
                                                            </svg>
                                                        </span>
                                                        <span class="category__text"><?php echo $category->name ?></span>
                                                    </a>
                                                    <?php $subcats = $category->getChildren() ?>
                                                    <?php if($subcats): ?>
                                                        <div class="subcategory category__subcategory">
                                                            <ul class="subcategory__list">
                                                                <?php foreach ($subcats as $subcat): ?>
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
                        </ul>
                    </nav>
                    <a href="#" id="esc" class="esc">
                        <div class="esc__icon esc__icon_cross1">
                            <svg class="svg esc__svg esc__svg_cross1">
                                <use xlink:href="/img/sprite-sheet.svg#cross1"/>
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
                                <a href="#" class="common__heading">Свяжитесь с нами</a>
                                <ul class="common__list">
                                    <li class="common__item common__item_flex">
                                        <div class="common__icon">
                                            <svg class="common__svg common__svg_comments">
                                                <use xlink:href="/img/sprite-sheet.svg#comments"/>
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
                                                <use xlink:href="/img/sprite-sheet.svg#place"/>
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
                                                <use xlink:href="/img/sprite-sheet.svg#time"/>
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
                                <use xlink:href="/img/sprite-sheet.svg#cross1"/>
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
                                        <use xlink:href="/img/sprite-sheet.svg#search"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
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
        </div>
    </div>
    
        <!-- Yandex.Metrika counter -->
<script type="text/javascript" >
   (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
   m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
   (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

   ym(52684090, "init", {
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true,
        webvisor:true
   });
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/52684090" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->

    <?php $this->endBody() ?>
    

    
    </body>
    </html>
<?php $this->endPage() ?>