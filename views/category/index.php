<?php

/**
 * @var $this yii\web\View
 * @var $categories \app\models\Category[]
 * @var $dataProvider \yii\data\ActiveDataProvider
 * */

// $categories - массив категорий
//$this->title = 'My Yii Application';
use yii\helpers\Url;
use app\components\Breadcrumbs;
use yii\helpers\Html;
use yii\widgets\ListView;
use yii\data\Pagination;

$this->registerJsFile('/js/order.js', ['depends' => \yii\web\JqueryAsset::className()]);

$category_main = $category;

if ($category->parent_id) {
    $this->params['breadcrumbs'][] = ['label' => $category_main->parent->name, 'class' => 'breadcrumb__link', 'url' => $category_main->parent->slug];
}
$this->params['breadcrumbs'][] = ['label' => $category_main->name, 'class' => 'breadcrumb__link', 'url' => $category_main->slug];
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
                            <span>показать весь каталог товаров</span>
                            <div class="drop-content__icon">
                                <svg class="svg drop-content__svg drop-content__svg_arrow2-dn">
                                    <use xlink:href="/img/sprite-sheet.svg#arrow2-dn" />
                                </svg>
                            </div>
                        </div>
                    </a>
                </div>
                <ul class="category__list">
                    <?php foreach ($categories as $item) : ?>
                        <?php $subcats = $item->getChildren();
                        $childrens = '';
                        $parent_active = $item->id == $category->id; ?>
                        <?php if ($subcats) : ?>
                            <?php
                            ob_start();
                            ?>
                            <div class="subcategory category__subcategory">
                                <ul class="subcategory__list">
                                    <?php foreach ($subcats as $subcat) :
                                        $child_active = $subcat->id == $category->id; 
                                        $parent_active = $parent_active ? : $child_active; ?>
                                        <li class="subcategory__item<?php echo $child_active ? ' active' : ''; ?>">
                                            <a href="<?php echo $subcat->slug ?>" class="subcategory__link"><?php echo $subcat->name ?></a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <?php
                            $childrens = ob_get_contents();
                            ob_end_clean();
                            ?>
                        <?php endif; ?>
                        <li class="category__item<?php echo $parent_active ? ' parent-active' : ''; ?>">
                            <a href="<?php echo $item->slug ?>" class="category__link">
                                <span class="category__icon">
                                    <svg class="svg category__svg category__svg_arrow2-right">
                                        <use xlink:href="/img/sprite-sheet.svg#arrow2-right" />
                                    </svg>
                                </span>
                                <span class="category__text"><?php echo $item->name ?></span>
                            </a><?php echo $childrens; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <div class="content-right">
            <div class="products">
                <div class="products-top">
                    <div class="content__title">
                        <?php
                        //   if($category_main->parent){
                        //       echo $category_main->parent->name . ' ';
                        //   }
                        echo $category_main->name;
                        ?>
                    </div>
                    <?php if ($dataProvider->count > 0) : ?>
                        <div class="content-btns products-top__content-btns">
                            <ul class="content-btns__list sort-ul-list">
                                <li class="content-btn content-btns__item ">
                                    <div class="drop-content content-btn__drop-content">
                                        <a href="#" class="drop-content__link" id="sort">
                                            <div class="drop-content__text">
                                                <?php if (Yii::$app->request->get('sort')  == '-price') : ?>
                                                    <span>по убыванию цены</span>
                                                <?php elseif (Yii::$app->request->get('sort') == 'price') : ?>
                                                    <span>по возрастанию цены</span>
                                                <?php elseif (Yii::$app->request->get('sort') == 'name') : ?>
                                                    <span>по наименованию</span>
                                                <?php else : ?>
                                                    <span>Сортировать по артикулу</span>
                                                <?php endif; ?>
                                                <div class="drop-content__icon">
                                                    <svg class="svg drop-content__svg drop-content__svg_arrow2-dn">
                                                        <use xlink:href="/img/sprite-sheet.svg#arrow2-dn" />
                                                    </svg>
                                                </div>
                                            </div>
                                        </a>
                                        <ul class="drop-content__list">
                                            <li class="drop-content__item">
                                                <a href="<?php echo Url::to([$category_main->slug]) ?>" class="drop-content__link">
                                                    <div class="drop-content__text">Сортировать по Артиклу</div>
                                                </a>
                                            </li>
                                            <li class="drop-content__item">
                                                <a href="<?php echo Url::to([$category_main->slug, 'sort' => '-price']) ?>" class="drop-content__link">
                                                    <div class="drop-content__text">по убыванию цены</div>
                                                </a>
                                            </li>
                                            <li class="drop-content__item">
                                                <a href="<?php echo Url::to([$category_main->slug, 'sort' => 'price']) ?>" class="drop-content__link">
                                                    <div class="drop-content__text">по возрастанию цены</div>
                                                </a>
                                            </li>
                                            <li class="drop-content__item">
                                                <a href="<?php echo Url::to([$category_main->slug, 'sort' => 'name']) ?>" class="drop-content__link">
                                                    <div class="drop-content__text">по наименованию</div>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="content-btn content-btns__item only-exist-link">
                                    <?php echo Html::a('<span>Показать только товары в наличии</span>', [$category_main->slug, $searchModel->formName() . '[flag]' => 1], ['class' => 'content-btn__link']) ?>
                                </li>
                            </ul>
                        </div>
                    <?php endif; ?>
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
	                        'tag'=>'li',
                            'class' => 'products__item'
                        ],
                        'viewParams' => [
                            'aname' => true,
                        ],
                    ]) ?>
                </div>
                <div class="products-bottom">
                    <?php if ($dataProvider->count > 0) : ?>
                        <div class="content-btns products__content-btns">
                            <ul class="content-btns__list">
                                <li class="content-btn content-btns__item only-exist-link">
                                    <?php echo Html::a('Показать только товары в наличии', [$category_main->slug, $searchModel->formName() . '[flag]' => 1], ['class' => 'content-btn__link']) ?>
                                </li>
                            </ul>
                            <div class="content-btns products__content-btns">
                                <?php
                                $more = Yii::$app->request->queryParams;
                                unset($more['id']);
                                $more['page'] = isset($more['page']) ? ($more['page'] + 1) : 2;

                                ?>
                                <?php if ($dataProvider->pagination->pageCount >= $more['page']) : ?>
                                    <a href="<?php echo Url::to([$category_main->slug] + $more); ?>" class="content-btn__link content-btn content-btn-more js-category__more">
                                        <span class="content-btn__text">Показать еще</span>
                                        <span class="content-btn__icon">
                                            <svg class="svg content-btn__svg content-btn__svg_arrow-updn">
                                                <use xlink:href="/img/sprite-sheet.svg#arrow-updn" />
                                            </svg>
                                        </span>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>
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