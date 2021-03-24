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
use yii\widgets\ActiveForm;

$this->registerJsFile('/js/order.js', ['depends' => \yii\web\JqueryAsset::className()]);


?>
<div class="content content_flip main__content">
    <div class="container container_fl-wr">
        <div class="content-left">
            <div class="izbrannoe">
                <div class="content__title">Избранное</div>
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
                <div class="content-btns products__content-btns">
                    <div class="content-btns products__content-btns">
				        <?php
				        $more = Yii::$app->request->queryParams;
				        unset($more['id']);
				        $more['page'] = isset($more['page'])?($more['page']+1):2;

				        ?>
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
        <div class="content-right">
            <div class="user-btns">
                <div class="content__title">Личный кабинет</div>
                <div class="drop-content content-btn__drop-content drop-content_phone">
                    <a href="#" class="drop-content__link" id="cab">
                        <div class="drop-content__text">
                            <span>Личный кабинет</span>
                            <div class="drop-content__icon">
                                <svg class="svg drop-content__svg drop-content__svg_arrow2-dn">
                                    <use xlink:href="/img/sprite-sheet.svg#arrow2-dn"/>
                                </svg>
                            </div>
                        </div>
                    </a>
                </div>
                <ul class="user-btns__list">
                    <li class="user-btns__item">
                        <a href="/cabinet" class="user-btns__link">Мой профиль</a>
                    </li>
                    <li class="user-btns__item">
                        <a href="/history" class="user-btns__link">История заказов</a>
                    </li>
                    <li class="user-btns__item user-btns__item_active">
                        <a href="/favorites" class="user-btns__link">Избранное</a>
                    </li>
                    <li class="user-btns__item">
                        <a href="/site/logout" class="user-btns__link">Выход</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="content-bottom">
		    <?php echo \app\widgets\productviews\ProductViewWidget::widget(); ?>
        </div>
    </div>
</div>


