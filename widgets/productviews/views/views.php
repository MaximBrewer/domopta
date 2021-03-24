<?php
/* @var $this \yii\web\View */
/* @var $products \app\models\Products[] */
?>
<?php if($products): ?>
<div class="content__carousel">
	<div class="content__title">Просмотренные товары</div>
	<ul class="products__list products__list_w">
		<?php foreach ($products as $product): ?>
		<?php echo $this->render('//common/_product', ['model' => $product]) ?>
		<?php endforeach; ?>
	</ul>
</div>
<?php endif; ?>