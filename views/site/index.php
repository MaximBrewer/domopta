<?php

/**
 * @var $this yii\web\View
 * @var $categories \app\models\Category[]
 * */

// $categories - массив категорий
//$this->title = 'My Yii Application';
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use yii\helpers\Html;
?>
<?php //if($this->beginCache('homepage')): ?>
<div class="catalog main__catalog">
    <div class="container container_dir-col">
	    <?= Yii::$app->params['page']->text; ?>
        <!-- <div class="main__title">Каталог товаров оптом</div> -->
        <ul class="catalog__list">

	        <?php foreach ($categories as $category): ?>
            <li class="catalog__item">
                <div class="catalog__item-inner">
                    <img src="<?php echo $category->getThumbUploadUrl('image'); ?>" alt="img" class="catalog__img">
                    <div class="catalog__overlay">
                        <div class="catalog__overlay-bottom">
                            <div class="common catalog__common">
                                <a href="<?php echo $category->slug; ?>" class="common__heading"><?php echo $category->name ?></a>
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
                        </div>
                    </div>
                </div>
            </li>
	        <?php endforeach; ?>

        </ul>
    </div>
</div>

<div class="news main__news">
    <div class="container container_dir-col">
        <div class="news-top">
            <div class="main__title">Новости</div>
            <ul class="news__list">
	            <?php foreach ($news as $item): ?>
                <li class="news__item">
                    <div class="news__item-top">
                        <img src="<?php echo $item->getThumbUploadUrl('image'); ?>" alt="news__img" class="news__img">
                    </div>
                    <div class="news__item-bottom">
                        <div class="news__heading"><?php echo $item->name; ?></div>
                        <a href="<?php echo $item->slug; ?>" class="news__link">читать полностью</a>
                    </div>
                </li>
	            <?php endforeach; ?>
            </ul>
        </div>
        <div class="news-bottom">
            <a href="<?php echo Url::toRoute(['/news']) ?>" class="dtn-news news__dtn-news">Все новости</a>
        </div>
    </div>
</div>
<div class="seo-text seo-text__main">
    <div class="container container_dir-col">
        <div class="seo-text__heading">

        </div>
        <div class="seo-text__text">
	        <?= Yii::$app->params['page']->additional_text; ?>
        </div>
    </div>
</div>

<?php //$this->endCache(); ?>
<?php //endif; ?>