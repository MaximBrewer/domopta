<?php
/* @var $this \yii\web\View */
/* @var $products \app\models\Products[] */
?>
<?php if ($products) : ?>
	<div class="content__carousel">
		<div class="content__title">Просмотренные товары</div>
		<div class="swiper-container gallery-common">
			<div class="swiper-wrapper">
				<?php foreach ($products as $product) : ?>
					<div class="swiper-slide">
						<?php echo $this->render('//common/_product', ['model' => $product]) ?>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	<?php endif; ?>