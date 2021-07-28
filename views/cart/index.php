<?php

/**
 * @var $this \yii\web\View
 * @var $cart \app\models\Cart[]
 */

use yii\grid\GridView;
use yii\helpers\Html;
use yii\grid\ActionColumn;
use app\components\Breadcrumbs;
use app\models\Products;

$this->registerJsFile('/js/cart.js?ver=2', ['depends' => \yii\web\JqueryAsset::class]);
$this->params['breadcrumbs'][] = 'Корзина';
$total = \app\models\Cart::getAmount();
$totalDamount = 0;
?>

<div class="content content_flip main__content">
    <div class="container container_fl-wr">
        <div class="content-left">
            <div class="cart-main main__cart-main">
                <div class="content__title">Корзина</div>
                <div class="finger">
                    <div class="finger__icon">
                        <svg class="finger__svg">
                            <use xlink:href="/img/sprite-sheet.svg#finger" />
                        </svg>
                    </div>
                    <div class="finger__text">
                        Если не видно таблицы целиком сделайте слайд по экрану пальцем вправо или в лево
                    </div>
                </div>
                <?php if (!empty($cart)) : ?>
                    <div class="cart-main-top">
                        <div class="btn-black form-tovar__btn-black">
                            <?php echo Html::a('Оформить заказ', ['/order'], ['class' => 'btn-black__link order_link']); ?>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="cart-main-middle">
                    <ul class="cart-main__list">
                        <div class="table-cart">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Товар</th>
                                        <th>Цвет</th>
                                        <th>Цена (шт)</th>
                                        <th>Шт. в уп.</th>
                                        <th>кол-во</th>
                                        <th>Всего (шт)</th>
                                        <th>сумма</th>
                                        <th>операция</th>
                                    </tr>
                                </thead>
                                <tbody class="cart-main__item">
                                    <?php foreach ($cart as $item) :
                                        if (!$item->product) continue;
                                    ?>
                                        <tr>
                                            <td rowspan="2" class="first-td">
                                                <div class="photos-tovar__item cart-main__pic">
                                                    <a href="<?php echo $item->product->slug ?>" target="_blank">
                                                        <img src="<?php echo isset($item->product->pictures[0]) ? $item->product->pictures[0]->getUrl('small') : '/img/d.jpg' ?>" alt="img" class="photos-tovar-cart__img cart-main__img">
                                                    </a>
                                                </div>
                                                <span><?php echo $item->product->article ?></span>
                                            </td>
                                            <td colspan="7" class="cart-main__item-desc thcart1"><span><?php echo $item->product->name ?></span></td>
                                        </tr>
                                        <tr>
                                            <td><?php
                                                $str = '';
                                                foreach ($item->details as $detail) {
                                                    if ($detail->amount > 0) {
                                                        if ($detail->color == 'default' && $item->product->flag) {
                                                            $str .= '<span></span><br />';
                                                        } elseif ($detail->color == 'default' && !$item->product->flag) {
                                                            $str .= '<span class="cart_selled cart_default_selled">товар уже продан</span><br />';
                                                        } elseif ($item->product->hasColor($detail->color)) {
                                                            if (!$item->product->flag)
                                                                $str .= '<span class="cart_selled">' . $detail->color . '</span><br />';
                                                            else
                                                                $str .= '<span>' . $detail->color . '</span><br />';
                                                        } else {
                                                            $str .= '<span class="cart_selled">' . $detail->color . '</span><br />';
                                                        }
                                                    }
                                                }
                                                echo $str;
                                                ?></td>
                                            <td class="text-nowrap">
                                                <?php
                                                $str = '';
                                                foreach ($item->details as $detail) {
                                                    if ($detail->amount > 0) {
                                                        $pprice = \Yii::$app->user->identity->profile->type == 2 ? $item->product->price2 : $item->product->price;
                                                        $str .= $item->price && $pprice != $item->price ? '<span class="old">' . number_format($item->price, 2, ',<span class="kopeyki">', '') . '</span></span><span>' . number_format($item->product->price, 2, ',<span class="kopeyki">', '') . '</span></span>' : number_format($pprice, 2, ',<span class="kopeyki">', '') . '</span>';
                                                    } else {
                                                        $str .= '&nbsp;';
                                                    }
                                                    $str .= '<br />';
                                                }
                                                echo $str;
                                                ?>
                                            </td>
                                            <td class="text-nowrap">
                                                <?php $str = '';
                                                foreach ($item->details as $detail) {
                                                    if ($detail->amount > 0) {
                                                        $str .= ($item->product->pack_quantity ? $item->product->pack_quantity : 1) . '<br />';
                                                    }
                                                }
                                                echo $str;
                                                ?>
                                            </td>
                                            <td class="input-td text-nowrap">
                                                <?php $str = '';
                                                foreach ($item->details as $detail) {
                                                    if ($detail->amount > 0) {
                                                        if ($item->product->pack_quantity) {
                                                            $shtup = 'уп.';
                                                        } else {
                                                            $shtup = 'шт.';
                                                        }
                                                        $str .= Html::input('number', 'color[' . $detail->color . ']', $detail->amount, ["min" => "1", 'class' => 'cart-main__amount', 'data-id' => $detail->id]) . $shtup . '<br />';
                                                    }
                                                }
                                                echo $str;
                                                ?></td>
                                            <td class="text-nowrap">
                                                <?php $str = '';
                                                foreach ($item->details as $detail) {
                                                    if ($detail->amount > 0) {
                                                        $damout = ($item->product->pack_quantity ? $item->product->pack_quantity : 1) * $detail->amount;
                                                        $totalDamount += $damout;
                                                        $str .= '<span data-id="' . $detail->id . '" class="detail-amount">' . $damout . '</span><br />';
                                                    }
                                                }
                                                echo $str;
                                                ?></td>
                                            <td class="text-nowrap">
                                                <?php
                                                $str = '';
                                                foreach ($item->details as $detail) {
                                                    if ($detail->amount > 0) {
                                                        $quantity = $item->product->pack_quantity ? $item->product->pack_quantity : 1;
                                                        $str .= '<span class="detail-sum" data-id="' . $detail->id . '" >' . Products::formatPrice($item->product->getUserPrice() * $quantity * $detail->amount) . '</span><br />';
                                                    }
                                                }
                                                echo $str;
                                                ?>
                                            </td>
                                            <td class="text-nowrap">
                                                <?php
                                                $str = '';
                                                foreach ($item->details as $k => $detail) {
                                                    if ($k) echo '<br/>';
                                                    if ($detail->amount > 0) {
                                                        $fill_class = "";
                                                        if (($detail->color != 'default' || !$item->product->flag) && !$item->product->hasColor($detail->color)) {
                                                            $fill_class = "fill_red";
                                                        } ?>
                                                        <a class="cart-main-btn cart-main-btn__icon" href="/cart/delete?id=<?= $detail->id; ?>" alt="Удалить из корзины" title="Удалить из корзины" data-confirm="Вы уверены, что хотите удалить этот элемент?" data-method="post" data-popup="cart_delete">
                                                            <svg class="svg cart-main-btn__svg cart-main-btn__svg_cross1 <?= $fill_class; ?>">
                                                                <use xlink:href="/img/sprite-sheet.svg#cross1"></use>
                                                            </svg>
                                                        </a>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="8" class="td-bottom">
                                                <?php echo Html::textInput('memo', $item->memo, ['data-id' => $item->id, 'class' => 'cart-main__comment memo', 'placeholder' => 'Примечание:']) ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </ul>
                </div>
                <div class="cart-flex-bottom">
                    <div>
                        <?php echo Html::a('Очистить корзину', ['javascript:;'], ['class' => 'btn-black__link', 'onclick' => '$(".cart_popup_overley").css("display", "block");$(".cart_popup.cart_clean").css("display", "flex");return false;']); ?>
                        <?php echo Html::a('Удалить проданные', ['/cart/clear'], ['class' => 'btn-black__link']); ?>
                    </div>
                    <div class="cart-main-bottom">
                        <div class="cart-main-sum text-nowrap">
                            <span>Общее кол-во:</span>
                            <span class="cart-main-quantity"><?php echo $totalDamount ?></span>
                            шт.
                        </div>
                        <div class="cart-main-sum text-nowrap">
                            <span>Общая сумма:</span>
                            <span class="cart-main-num"><?php echo $total['sum'] ?></span>
                            руб.
                        </div>
                        <?php if (!empty($cart)) : ?>
                            <div class="btn-black form-tovar__btn-black">
                                <!-- <?php echo Html::a('Очистить корзину', ['/cart/flush'], ['class' => 'btn-black__link order_link']); ?>
                            <?php echo Html::a('Удалить проданные', ['/cart/clear'], ['class' => 'btn-black__link order_link']); ?>&nbsp; -->
                                <?php echo Html::a('Оформить заказ', ['/order'], ['class' => 'btn-black__link order_link']); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-right">
            <div class="user-btns">
                <div class="content__title">Личный кабинет</div>
                <ul class="user-btns__list">
                    <li class="user-btns__item">
                        <a href="/cabinet" class="user-btns__link">Мой профиль</a>
                    </li>
                    <li class="user-btns__item">
                        <a href="/history" class="user-btns__link">История заказов</a>
                    </li>
                    <li class="user-btns__item">
                        <a href="/favorites" class="user-btns__link">Избранное</a>
                    </li>
                    <li class="user-btns__item">
                        <a href="/cabinet/password" class="user-btns__link">Смена пароля</a>
                    </li>
                    <li class="user-btns__item">
                        <a href="/cabinet/csv" target="_blank" class="user-btns__link">Скачать каталог (CSV)</a>
                    </li>
                    <li class="user-btns__item">
                        <a href="/cabinet/xml" target="_blank" class="user-btns__link">Скачать каталог (XML)</a>
                    </li>
                    <li class="user-btns__item">
                        <a class="user-btns__link" href="/site/logout" alt="Выход" title="Выход" data-confirm="Вы действительно хотите выйти?" data-method="get" data-popup="logout_popup">Выход</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="cart_popup_overley"></div>
<div class="container container_pop-small cart_popup cart_sold">
    <div class="reg-pop-inner reg-pop-inner-cart">
        <div class="reg-pop__step1 reg-pop__step1_block cart_popup_selled">
            В КОРЗИНЕ ЕСТЬ ТОВАРЫ, КОТОРЫЕ УЖЕ ПРОДАНЫ И ОТСУТСТВУЮТ НА СКЛАДЕ.<br /><br />
            ДЛЯ ОФОРМЛЕНИЯ ЗАКАЗА УДАЛИТЕ ОТСУТСТВУЮЩИЕ ТОВАРЫ ИЗ КОРЗИНЫ.<br /><br />
            (данные товары выделены красным цветом)
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
<div class="container container_pop-small cart_popup cart_empty">
    <div class="reg-pop-inner reg-pop-inner-cart">
        <div class="reg-pop__step1 reg-pop__step1_block cart_popup_selled">
            НЕВОЗМОЖНО ОФОРМИТЬ ЗАКАЗ, <br /><br />
            ТАК КАК В КОРЗИНЕ ОТСУТСТВУЮТ ТОВАРЫ
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
<div class="container container_pop-small cart_popup cart_clean">
    <div class="reg-pop-inner reg-pop-inner-cart">
        <div class="cart_popup_clean">
            <h2 class="history_cancel__h2">Очистка корзины</h2>
            <h3> Вы уверены, что хотите полностью очистить Корзину и удалить все выбранные товары?
            </h3>
            <div class="cart_popup_btn">
                <a href="/cart/flush" class="btn-black__link">Да</a>
                <a href="javascript:;" class="btn-black__link close-pop">Нет</a>
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
<div class="container container_pop-small cart_popup" id="cart_delete">
    <div class="reg-pop-inner reg-pop-inner-cart">
        <div class="cart_popup_clean">
            <h2 class="history_cancel__h2">Удаление товара</h2>
            <h3>Вы уверены, что хотите удалить этот товар?
            </h3>
            <div class="cart_popup_btn">
                <a href="javascript:;" class="btn-black__link yes-button close-pop">Да</a>
                <a href="javascript:;" class="btn-black__link close-pop">Нет</a>
            </div>
        </div>
        <a href="#" id="esc" class="esc close-h">
            <div class="esc__icon esc__icon_cross1">
                <svg class="svg esc__svg esc__svg_cross1">
                    <use xlink:href="/img/sprite-sheet.svg#cross1"></use>
                </svg>
            </div>
        </a>
    </div>
</div>
<?php if (Yii::$app->user->identity->profile->type) : ?>
    <div class="container container_pop-small cart_popup cart_minimum">
        <div class="reg-pop-inner reg-pop-inner-cart">
            <div class="cart_popup_minimum py-3 px-4">
                <h3>
                    Сумма Вашего заказа меньше необходимой минимальной суммы.<br />
                    По Условиям Работы заказы формируются<br />
                    от <?php echo (int)Yii::$app->settings->get('Settings.min' . Yii::$app->user->identity->profile->type); ?> рублей.<br />
                    Необходимо увеличить свой заказ.<br />
                    Иначе, заказ не будет обработан, либо будет пересчитан по Мелкооптовой цене.<br />
                </h3>
                <div class="cart_popup_btn">
                    <a href="/order" class="btn-black__link">Все равно оформить заказ</a>
                    <a href="javascript:;" class="btn-black__link close-pop">Вернуться в Корзину</a>
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
    <script>
        var minimalSumm = <?php echo (int)Yii::$app->settings->get('Settings.min' . Yii::$app->user->identity->profile->type); ?>;
    </script>
<?php endif; ?>