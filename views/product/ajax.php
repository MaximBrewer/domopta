<?php

/**
 * @var $this \yii\web\View
 * @var $model \app\models\Products
 * @var $category \app\models\Category
 * @var $form_model \app\models\ProductForm
 * @var $form \yii\widgets\ActiveForm;
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\components\Breadcrumbs;

//$this->registerJsFile('/js/order.js', ['depends' => \yii\web\JqueryAsset::className()]);
//$this->registerJsFile('/js/slick.min.js', ['depends' => \yii\web\JqueryAsset::className()]);
//$this->registerCssFile('/js/slick-theme.css');

$this->title = $model->name . ' | ' . $model->category->title;
Yii::$app->params['page']->keywords = $model->category->keywords;
Yii::$app->params['page']->description = $model->category->description;

$category = $model->category;

if ($category->parent) {
    $this->params['breadcrumbs'][] = ['label' => $category->parent->name, 'url' => $category->parent->slug];
}
$this->params['breadcrumbs'][] = ['label' => $category->name, 'url' => $category->slug];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => $model->slug];

//$this->registerJs("$('.gallery').slick({
//                infinite: true,
//                slidesToShow: 6,
//                slidesToScroll: 2
//            });", \yii\web\View::POS_READY);

?>
<div class="container container_pop-big">
    <div class="look-pop-inner">
        <div class="tovar look-pop__tovar">
            <div class="tovar-left">
                <style>
                    .lSSlideOuter.vertical {
                        padding-left: 55px;
                        padding-right: 0 !important;
                    }

                    .lSSlideOuter.vertical .lSGallery {
                        left: 0;
                    }
                </style>
                <?php $pictures = $model->pictures; ?>
                <div class="photos-tovar tovar__photos-tovar <?php if (count($pictures) > 3) echo 'tovar__four' ?>" style="display:none;">
                    <div class="display display_pp"></div>
                    <?php if (count($pictures) > 3) : ?>
                        <div class="tovar__arrow__wrapper tovar__arrow__wrapperPP">
                            <div class="photos-tovar__arrow photos-tovar__arrow_l"><span class="photos-tovar__link photos-tovar__icon"><svg class="svg photos-tovar__svg photos-tovar__svg_arrow2-left">
                                        <use xlink:href="/img/sprite-sheet.svg#arrow2-left" />
                                    </svg></span></div>
                            <div class="photos-tovar__arrow photos-tovar__arrow_r"><span class="photos-tovar__link photos-tovar__icon"><svg class="svg photos-tovar__svg photos-tovar__svg_arrow2-right">
                                        <use xlink:href="/img/sprite-sheet.svg#arrow2-right" />
                                    </svg></span></div>
                        </div>
                    <?php endif; ?>
                    <ul class="photos-tovar__list_pp <?php if (count($pictures) < 2) echo 'tovar__one' ?>">
                        <?php if (!empty($pictures)) : ?>
                            <?php
                            $i = 0;
                            foreach ($pictures as $pic) :
                                $i++;
                            ?>
                                <li class="photos-tovar__item" data-thumb="<?php echo $pic->getUrl('big', $pic->order) ?>" data-i="<?php echo $i; ?>">
                                    <img src="<?php echo $pic->getUrl('big', $pic->order) ?>" alt="Оптом - <?php echo str_replace('"', '', $model->name) ?> - <?php echo $model->article ?> - domopta.ru" class="photos-tovar__img pic_p">
                                </li>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <li class="photos-tovar__item" data-thumb="/img/dt.jpg">
                                <img src="/img/dt.jpg" alt="img" class="photos-tovar__img pic_p">
                            </li>
                        <?php endif; ?>
                    </ul>
                    <?php if (count($pictures) > 1) : ?>
                        <div class="count-photo">
                            <span class="current-photo">1</span> / <span><?php echo count($pictures); ?></span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="tovar-right">
                <div class="tovar__title"><?php echo $model->name ?></div>
                <div class="info-tovar tovar__info-tovar">
                    <ul class="info-tovar__list">
                        <li class="info-tovar__item">
                            <span class="info-tovar__name">Артикул:&nbsp;&nbsp;&nbsp;</span>
                            <span class="info-tovar__vlue"><?php echo $model->article ?></span>
                        </li>
                        <?php if ($model->tradekmark) : ?>
                            <li class="info-tovar__item">
                                <span class="info-tovar__name">Товарный знак:&nbsp;&nbsp;&nbsp;</span>
                                <span class="info-tovar__vlue"><?php echo $model->tradekmark ?></span>
                            </li>
                        <?php endif; ?>
                        <?php if ($model->size) : ?>
                            <li class="info-tovar__item">
                                <span class="info-tovar__name">Размеры:&nbsp;&nbsp;&nbsp;</span>
                                <span class="info-tovar__vlue"><?php echo $model->size ?></span>
                            </li>
                        <?php endif; ?>
                        <?php if ($model->consist) : ?>
                            <li class="info-tovar__item">
                                <span class="info-tovar__name">Состав:&nbsp;&nbsp;&nbsp;</span>
                                <span class="info-tovar__vlue"><?php echo $model->consist ?></span>
                            </li>
                        <?php endif; ?>
                        <?php if ($model->category->country) : ?>
                            <li class="info-tovar__item">
                                <span class="info-tovar__name">Страна:&nbsp;&nbsp;&nbsp;</span>
                                <span class="info-tovar__vlue"><?php echo $model->category->country ?></span>
                            </li>
                        <?php endif; ?>
                        <?php if ($model->category->certificate) : ?>
                            <li class="info-tovar__item">
                                <span class="info-tovar__name">Сертификат:&nbsp;&nbsp;&nbsp;</span>
                                <span class="info-tovar__vlue"><?php echo $model->category->certificate ?></span>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
                <div class="tovar__text"><?php echo $model->description ?></div>
                <div class="tag-tovar tovat__tag-tovar">
                    <div class="tag-tovar-left">
                        <?php if (Yii::$app->user->isGuest || !Yii::$app->user->identity->profile->type) : ?>
                            <div class="tag-tovar__holesale">
                                <div class="tag-tovar-top">
                                    <span class="tag-tovar__title">оптовая цена</span>
                                </div>
                                <div class="tag-tovar__bottom">
                                    <span class="tag-tovar__text">Цена за 1 шт:&nbsp;&nbsp;&nbsp;</span>
                                    <span class="tag-tovar__price"><?php echo $model::formatPrice($model, ['price']) ?></span> &#8381;</span>
                                </div>
                            </div>
                            <div class="tag-tovar__retail">
                                <div class="tag-tovar-top">
                                    <span class="tag-tovar__title">мелкооптовая цена</span>
                                </div>
                                <div class="tag-tovar-bottom">
                                    <span class="tag-tovar__text">Цена за 1 шт:&nbsp;&nbsp;&nbsp;</span>
                                    <span class="tag-tovar__price"><?php echo $model::formatPrice($model, ['price2', 'price']) ?></span> &#8381;</span>
                                </div>
                            </div>

                        <?php else : ?>
                            <?php if (Yii::$app->user->identity->profile->type == 2) : ?>
                                <div class="tag-tovar__retail">
                                    <div class="tag-tovar-top">
                                        <span class="tag-tovar__title">мелкооптовая цена</span>
                                    </div>
                                    <div class="tag-tovar-bottom">
                                        <span class="tag-tovar__text">Цена за 1 шт:&nbsp;&nbsp;&nbsp;</span>
                                        <span class="tag-tovar__price"><?php echo $model::formatPrice($model, ['price2', 'price']); ?></span> &#8381;</span>
                                    </div>
                                </div>
                            <?php elseif (Yii::$app->user->identity->profile->type == 1 || Yii::$app->user->identity->profile->type == 3) : ?>
                                <div class="tag-tovar__holesale">
                                    <div class="tag-tovar-top">
                                        <span class="tag-tovar__title">оптовая цена</span>
                                    </div>
                                    <div class="tag-tovar__bottom">
                                        <span class="tag-tovar__text">Цена за 1 шт:&nbsp;&nbsp;&nbsp;</span>
                                        <span class="tag-tovar__price"><?php echo $model::formatPrice($model, ['price']) ?></span> &#8381;</span>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                        <?php if (!Yii::$app->user->isGuest && $model->pack_quantity) : ?>
                            <div class="package-tovar tag-tovar__package-tovar">
                                <ul class="package-tovar__list">
                                    <li class="package-tovar__item">
                                        <span class="package-tovar__text">количество штук в упаковке:&nbsp;&nbsp;&nbsp;</span>
                                        <span class="package-tovar__amount"><?php echo $model->pack_quantity ?> <span class="shtuk">шт</span></span>
                                    </li>
                                    <?php if (Yii::$app->user->identity->profile->type && Yii::$app->user->identity->profile->name) : ?>
                                        <?php if (Yii::$app->user->identity->profile->type == 2) : ?>
                                            <li class="package-tovar__item">
                                                <span class="package-tovar__text">цена за упаковку: &nbsp;&nbsp;&nbsp;</span>
                                                <span class="package-tovar__amount"><?php echo $model::formatPrice($model, ['pack_price2']) ?></span> &#8381;</span>
                                            </li>
                                        <?php else : ?>
                                            <li class="package-tovar__item">
                                                <span class="package-tovar__text">цена за упаковку: &nbsp;&nbsp;&nbsp;</span>
                                                <span class="package-tovar__amount"><?php echo $model::formatPrice($model, ['pack_price']) ?></span> &#8381;</span>
                                            </li>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="tag-tovar-right">
                        <div class="tag-tovar-btn">
                            <a href="#" class="tag-tovar-btn__link" data-id="<?php echo $model->id; ?>" <?php if (Yii::$app->user->isGuest) : ?> onclick="$('#enter').click(); return false;" <?php endif; ?>>
                                <span class="tag-tovar-btn__text">Добавить в избранное</span>
                                <span class="tag-tovar-btn__icon">
                                    <svg class="tag-tovar-btn__svg tag-tovar-btn__svg_heart1">
                                        <use xlink:href="/img/sprite-sheet.svg#heart1" />
                                    </svg>
                                    <svg class="tag-tovar-btn__svg tag-tovar-btn__svg_heart2">
                                        <use xlink:href="/img/sprite-sheet.svg#heart2" />
                                    </svg><span class="help">
                                        <span class="help__text">Добавить в избранное</span>
                                    </span>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="form-tovar tovar__form-tovar">
                    <?php if ($model->flag == 1) : ?>
                        <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->getIsActive()) : ?>
                            <?php $form = ActiveForm::begin(['id' => 'product-form', 'action' => ['/product/add']]) ?>
                            <?php echo $form->field($form_model, 'product_id')->label(false)->hiddenInput(['value' => $model->id]); ?>
                            <?php if ($yap = trim($model->color) == '') { ?>
                                <div class="form-tovar__colors">
                                    <ul class="form-tovar__list">
                                        <li class="form-tovar__item">
                                            <label class="form-tovar__label">
                                                <div class="form-tovar__title">Кол-во:</div>
                                                <span class="input-count-box">
                                                    <button type="button" class="input-color-minus">-</button>
                                                    <?php echo Html::activeInput('text', $form_model, 'colors[default]', ['class' => 'form-tovar__input input-color', 'min' => 0]) ?>
                                                    <button type="button" class="input-color-plus">+</button>
                                                </span>
                                            </label>
                                        </li>
                                    </ul>
                                </div>
                            <?php } else { ?>
                                <?php $colors = explode(',', $model->color); ?>
                                <div class="h2colors">Цвета, доступные для заказа:</div>
                                <div class="form-tovar__colors">
                                    <ul class="form-tovar__list">
                                        <?php
                                        $i = 0;
                                        foreach ($colors as $color) { ?>
                                            <li class="form-tovar__item">
                                                <label class="form-tovar__label">
                                                    <div class="form-tovar__title"><?php echo $color ?></div>
                                                    <span class="input-count-box">
                                                        <button type="button" class="input-color-minus">-</button>
                                                        <?php echo Html::activeInput('text', $form_model, 'colors[' . $color . ']', ['class' => 'form-tovar__input input-color', 'min' => 0]) ?>
                                                        <button type="button" class="input-color-plus">+</button>
                                                    </span>
                                                </label>
                                            </li>
                                        <?php
                                            $i++;
                                            if ($i > 20) {
                                                $i = 0;
                                                echo "</ul><ul class=\"form-tovar__list col-2\">";
                                            }
                                        } ?>
                                    </ul>
                                </div>
                            <?php } ?>
                            <div class="form-tovar-btn">
                                <?php echo Html::submitButton('
                                <span class="form-tovar__text">Добавить в корзину</span>
                                <span class="form-tovar-btn__icon">
                                    <svg class="form-tovar-btn__svg form-tovar-btn__svg_basket1">
                                        <use xlink:href="/img/sprite-sheet.svg#basket1"/>
                                    </svg>
                                    <svg class="form-tovar-btn__svg form-tovar-btn__svg_basket2">
                                        <use xlink:href="/img/sprite-sheet.svg#basket2"/>
                                    </svg>
                                </span>', ['class' => 'form-tovar-btn__link']) ?>
                            </div>
                            <?php ActiveForm::end() ?>
                        <?php endif; ?>
                    <?php else : ?>
                        <?php echo Yii::$app->settings->get('Settings.notify_product_absend') ?>
                    <?php endif; ?>
                </div>
                <?php if (!Yii::$app->user->isGuest && $model->flag == 1 && Yii::$app->user->identity->profile->type && Yii::$app->user->identity->profile->name) : ?>
                    <?php //if (trim($model->color) != '') : 
                    ?>
                    <div class="tovar__help">Укажите напротив каждого цвета необходимое количество товара, затем нажмите кнопку "Добавить&nbsp;в&nbsp;корзину", и весь выбранный Вами товар попадет в Корзину.</div>
                    <?php //endif; 
                    ?>
                <?php else : ?>
                    <?php if (!Yii::$app->user->isGuest) : ?>
                        <div class="tovar__unreg">
                            <?php if ($model->flag == 1) : ?>
                                ДЛЯ ЗАКАЗА ТОВАРОВ ВАМ НЕОБХОДИМО ПРОЙТИ ПОЛНУЮ <a href="/reg/full?step=1" class="reg-link">РЕГИСТРАЦИЮ</a>
                            <?php endif; ?>
                        </div>
                    <?php else : ?>
                        <div class="tovar__unreg">
                            <?php if ($model->flag == 1) : ?>
                                ДЛЯ ЗАКАЗА ТОВАРОВ ВАМ НЕОБХОДИМО ПРОЙТИ ПОЛНУЮ <a href="#" class="reg-link" id="reg2">РЕГИСТРАЦИЮ</a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
        <a href="#" id="esc" class="esc">
            <div class="esc__icon esc__icon_cross">
                <svg class="svg esc__svg esc__svg_cross1">
                    <use xlink:href="/img/sprite-sheet.svg#cross1" />
                </svg>
            </div>
        </a>
    </div>
</div>