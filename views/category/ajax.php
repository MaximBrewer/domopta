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
$category_main = $category;
?>
<?php $this->beginBlock('content') ?>
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
<?php $this->endBlock() ?>
<?php $this->beginBlock('more') ?>
<?php
$more = Yii::$app->request->queryParams;
unset($more['id']);
$more['page'] = isset($more['page'])?($more['page']+1):2;
if($dataProvider->count >= $dataProvider->pagination->pageSize):
?>
    <a href="<?php echo Url::to([$category_main->slug] + $more); ?>" class="content-btn__link content-btn content-btn-more js-category__more">
        <span class="content-btn__text">Показать еще</span>
        <span class="content-btn__icon">
                                    <svg class="svg content-btn__svg content-btn__svg_arrow-updn">
                                        <use xlink:href="/img/sprite-sheet.svg#arrow-updn"/>
                                    </svg>
                                </span>
    </a>
<?php
endif;
$this->endBlock() ?>
<?php $this->beginBlock('pager') ?>
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
<?php $this->endBlock() ?>