<?php

/** @var $model \app\models\Products */

use yii\helpers\Html;
?>
<li class="products__item" <?php if (isset($aname) && $aname) : ?> id="product_<?php echo $model->id ?>" <?php endif; ?>>
	<a href="<?php echo $model->slug ?>" class="product">
		<div class="product-top">
			<div class="product__pic">
				<span href="<?php echo $model->slug ?>">
					<img src="<?php echo isset($model->pictures[0]) ? $model->pictures[0]->getUrl() : '/img/d.jpg' ?>" alt="img" class="product__img">
					<div class="product-overlay product__product-overlay">
						<span href="<?php echo $model->slug ?>" class="product__icon-eye">
							<svg class="svg product__svg product__svg_eye">
								<use xlink:href="/img/sprite-sheet.svg#eye" />
							</svg>
							<span>быстрый просмотр </span>
						</span>
					</div>
				</span>
			</div>
			<span class="product__icon-cross" data-id="<?php echo $model->id; ?>">
				<svg class="svg esc__svg esc__svg_cross1">
					<use xlink:href="/img/sprite-sheet.svg#cross1" />
				</svg>
			</span>
			<span class="product__icon-heart" data-id="<?php echo $model->id; ?>" <?php if (Yii::$app->user->isGuest) : ?> onclick="$('#enter').click(); return false;" <?php endif; ?>>
				<svg class="svg product__svg product__svg_heart1">
					<use xlink:href="/img/sprite-sheet.svg#heart1" />
				</svg>
				<svg class="svg product__svg product__svg_heart2">
					<use xlink:href="/img/sprite-sheet.svg#heart2" />
				</svg>
				<span class="help">
					<span class="help__text">Добавить в избранное</span>
				</span>
			</span>
		</div>
		<?php
		$string = $model->name;
		$pattern = '/([^,\.:;\(\)z]*)/iu';
		preg_match($pattern, $string, $matches);
		?>
		<div class="product-middle">
			<div class="product__code"><?php echo trim($matches[0]) ?></div>
			<div class="product__retail">
				<span class="product__retail-text">Артикул:</span>
				<span class="product__retail-price"><?php echo $model->article ?></span>
			</div>
			<?php if (Yii::$app->user->isGuest || !Yii::$app->user->identity->profile->type) : ?>
				<div class="product__holesale">
					<span class="product__holesale-text">Опт:</span>
					<span class="product__holesale-price"><?php echo $model::formatPrice($model, ['price']) ?><span>&nbsp;&#8381;</span></span> </span>
				</div>
				<div class="product__retail">
					<span class="product__retail-text">Мел/Опт:</span>
					<span class="product__retail-price"><?php echo $model->price2 ? $model::formatPrice($model, ['price2']) : $model::formatPrice($model, ['price']) ?><span>&nbsp;&#8381;</span></span> </span>
				</div>
			<?php else : ?>
				<div class="product__retail">
					<span class="product__retail-text"><?php
														if (Yii::$app->user->identity->profile->type == 1 || Yii::$app->user->identity->profile->type == 3) {
															echo 'Опт';
														} elseif (Yii::$app->user->identity->profile->type == 2) {
															echo 'Мел/Опт';
														}
														?>:</span>
					<span class="product__retail-price"><?php echo $model::formatPrice($model, [], 'getUserPrice') ?><span>&nbsp;&#8381;</span></span> </span>
				</div>
			<?php endif; ?>
		</div>
		<div class="product-bottom">
			<div class="product__availability"><?php echo $model->flag ? '<span class="t-stock">Товар в наличии</span>' : '<span class="t-sold">Товар продан</span>' ?></div>
			<div class="product__btn">
				<span class="product__link">подробнее</span>
			</div>
		</div>
	</a>
</li>