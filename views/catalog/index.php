<?php

/**
 * @var $this yii\web\View
 * @var $categories \app\models\Category[]
 * */

// $categories - массив категорий
//$this->title = 'My Yii Application';
use yii\helpers\Url;
use app\components\Breadcrumbs;
use yii\helpers\Html;
use yii\widgets\ListView;
use yii\data\Pagination;

$this->params['breadcrumbs'][] = ['label' => 'Каталог', 'class' => 'breadcrumb__link', 'url' => '/catalog']
?>
<div class="breadcrumb main__breadcrumb">
    <div class="container">
<?= Breadcrumbs::widget([
	'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
	'homeLink' => [
		'label' => 'Главная',
		'url' => '/',
		'class' => 'breadcrumb__link',
	],
	'tag' => 'ul',
	'options' => ['class' => 'breadcrumb__list'],
	'itemTemplate' => '<li class="breadcrumb__item">{link}</li>',
	'activeItemTemplate' => '<li class="breadcrumb__item">{link}</li>',
	'glue' => ''
]) ?>
    </div>
</div>

<div class="content main__content">
    <div class="container container_fl-wr">
        <div class="content-left">
            <div class="category content__category">
                <div class="content__title">Каталог</div>
                <div class="drop-content content-btn__drop-content drop-content_phone">
                    <a href="#" class="drop-content__link" id="cat">
                        <div class="drop-content__text">
                            <span>показать  весь каталог товаров</span>
                            <div class="drop-content__icon">
                                <svg class="svg drop-content__svg drop-content__svg_arrow2-dn">
                                    <use xlink:href="/img/sprite-sheet.svg#arrow2-dn"/>
                                </svg>
                            </div>
                        </div>
                    </a>
                </div>
                <ul class="category__list">
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
            </div>
        </div>
        <div class="content-right">
            <div class="products"> 
                <div class="products-top">
                    <div class="content__title">Все товары</div>
                    <div class="content-btns products-top__content-btns">
                        <ul class="content-btns__list">
                            <li class="content-btn content-btns__item ">
                                <div class="drop-content content-btn__drop-content">
                                    <a href="#" class="drop-content__link" id="sort" >
                                        <div class="drop-content__text">
                                            <span>Сортировать по Артиклу</span>
                                            <div class="drop-content__icon">
                                                <svg class="svg drop-content__svg drop-content__svg_arrow2-dn">
                                                    <use xlink:href="/img/sprite-sheet.svg#arrow2-dn"/>
                                                </svg>
                                            </div>
                                        </div>
                                    </a>
                                    <ul class="drop-content__list">
                                        <li class="drop-content__item">
                                            <a href="#" class="drop-content__link">
                                                <div class="drop-content__text">Сортировать по Артиклу</div>
                                            </a>
                                        </li>
                                        <li class="drop-content__item">
                                            <a href="#" class="drop-content__link">
                                                <div class="drop-content__text">Сортировать по Артиклу</div>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="content-btn content-btns__item ">
                                <a href="#" class="content-btn__link">Показать только товары в наличии</a>
                            </li>
                        </ul>
                    </div> 
                </div> 
                <div class="products-middle">
                <?php echo ListView::widget([
                        'dataProvider' => $dataProvider,
                        'itemView' => '//common/_product.php',
                        'layout' => "{items}",
                        'options' => [
                                'tag' => 'ul',
                                'class' => 'products__list'
                        ],
                        'itemOptions' => [
	                        'tag'=>false,
                        ],
                ]) ?>
                </div>
                <div class="products-bottom">
                    <div class="content-btns products-bottom__content-btns">
                        <ul class="content-btns__list">
                            <li class="content-btn content-btns__item">
                                <a href="#" class="content-btn__link">Показать только товары в наличии</a>
                            </li>
                        </ul>
                        <div class="content-btns products__content-btns">
                            <a href="#" class="content-btn__link content-btn content-btn-more">
                                <span class="content-btn__text">Показать еще</span>
                                <span class="content-btn__icon">
                                    <svg class="svg content-btn__svg content-btn__svg_arrow-updn">
                                        <use xlink:href="/img/sprite-sheet.svg#arrow-updn"/>
                                    </svg>
                                </span>
                            </a>
                        </div>
                    </div> 
                    <div class="pagination product__pagination">
                    <?php echo \yii\widgets\LinkPager::widget([
                            'pagination' => $dataProvider->pagination,
                            'options' => [
                                    'tag' => 'ul',
                                    'class' => 'pagination__list'
                            ],
                            'linkContainerOptions' => ['class' => 'pagination__item'],
                            'linkOptions' => ['class' => 'pagination__link'],
                            'prevPageLabel' => '
                                    <svg class="svg pagination__svg pagination__svg_arrow2-left">
                                        <use xlink:href="/img/sprite-sheet.svg#arrow2-left"/>
                                    </svg>
                                ',
                            'nextPageLabel' => '
                                    <svg class="svg pagination__svg pagination__svg_arrow2-right">
                                        <use xlink:href="/img/sprite-sheet.svg#arrow2-right"/>
                                    </svg>
                                '
                    ]);  ?>
                    </div>

                </div>
            </div>
        </div>
        <div class="content-bottom">
	        <?php echo \app\widgets\productviews\ProductViewWidget::widget(); ?>
        </div>
    </div>
</div>


