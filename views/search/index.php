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
<div class="content main__content">
    <div class="container container_fl-wr">
        <div class="content-left">
            <div class="category content__category">
                <div class="content__title">Каталог</div>
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
            <div class="search-content content__search-content">
                <div class="search-content-top">
                    <div class="content__title">
                        <span class="search__result">Результаты поиска</span>
                        <span class="search__string"><?php echo $searchModel->text; ?></span>
                    </div>
                </div>
                <div class="search-content-middle">
                    <div class="search-content__form">
                        <?php $form = ActiveForm::begin(['method' => 'get']) ?>
                        <?php echo Html::activeTextInput($searchModel, 'text', ['class' => 'search-content__input-search']) ?>
                        <?php echo Html::submitInput('Поиск', ['class' => 'search-content__btn-black btn-black__link']) ?>
                        <?php ActiveForm::end() ?>
                    </div>
                </div>
                <div class="products">
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
//                                'emptyText' => '<div class="msg search-content__msg"><div class="msg-top">По вашему запросу ничего не найдено</div>
//        <div class="msg-bottom">Попробуйте изменить формулировку или свяжитесь с нашим оператором по телефону: <span class="msg-phone">'.Yii::$app->settings->get('Settings.phone_call').'</span></div></div>'
                            'emptyText' => '<div class="msg search-content__msg"><div class="msg-top">По вашему запросу ничего не найдено</div>
        <div class="msg-bottom">Попробуйте изменить формулировку запроса. </div>'
                            ]) 
                        ?>
                        
                    </div>
                </div>
                <div class="products-bottom">
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


