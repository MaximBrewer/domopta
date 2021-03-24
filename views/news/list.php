<?php
/**
 * @var $this \yii\web\View
 * @var $dataProvider \yii\data\ActiveDataProvider;
 * @var $searchModel \app\models\NewsSearch;
 */
use yii\widgets\ListView;
use app\components\Breadcrumbs;
use app\components\LinkPager;
use yii\helpers\Html;

$this->params['breadcrumbs'][] = ['label' => 'Новости', 'url' => ['/news']]
?>
<div class="news main__news section">
    <div class="container container_dir-col">
        <div class="news-top">
            <div class="main__title">Новости</div>
        <?php //echo Yii::$app->params['page']->text ?>
        <?php echo ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => '_item',
            'layout' => '{items}',
            'options' => ['tag' => 'ul', 'class' => 'news__list'],
            'itemOptions' => [
                    'tag' => 'li',
                    'class' => 'news__item'
            ]
        ]) ?>
        <?php if($dataProvider->pagination): ?>
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
        <?php endif; ?>
        <?php //echo Yii::$app->params['page']->additional_text ?>
        </div>
        </div>
        </div>