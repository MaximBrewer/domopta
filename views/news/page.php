
<?php
/**
 * @var $this \yii\web\View
 * @var $model \app\models\News;
 */

use app\components\Breadcrumbs;

$this->params['breadcrumbs'][] = ['label' => 'Новости', 'class' => 'breadcrumb__link', 'url' => ['/news']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => $model->slug];
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
        <div class="novost">
            <div class="novost-top">
                <div class="content__title"><?php echo $model->name ?></div>
                <div class="novost__text">
                    <div class="novost__text-pic">
                        <img src="<?php echo $model->getThumbUploadUrl('image')?>" alt="domopta.ru - <?php echo str_replace('"', '', $model->name); ?>" class="novost__text-img">
                    </div>
                    <p>
	                    <?php echo $model->text ?>
                    </p>
                </div>
            </div>
            <div class="novost-middle">
            </div>
        </div>
    </div>
</div>


