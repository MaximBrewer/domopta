<?php
/* @var $this \yii\web\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */

use yii\grid\GridView;
use yii\helpers\Html;
?>
<div class="container">
	<div class="text-right">
		<a href="/adminka/bigcart/xls" class="btn btn-success">Реестр Корзина от 3000 (XLS)</a>
	</div>
	<div class="nouse">
		<?php echo GridView::widget([
			'dataProvider' => $dataProvider,
			'columns' => [
				[
					'label' => 'ФИО',
					'value' => function ($model) {
						return $model->profile->lastname . ' ' . $model->profile->name . ' ' . $model->profile->surname;
					}
				],
				[
					'label' => 'Город',
					'value' => function ($model) {
						return $model->profile->city;
					}
				],
				[
					'label' => 'Область',
					'value' => function ($model) {
						return $model->profile->region;
					}
				],
				[
					'attribute' => 'username',
					'label' => 'Телефон',
					'value' => function ($model) {
						if (\Yii::$app->user->identity->role == 'admin') {
							return Html::a($model->username, ['/user/admin/update', 'id' => $model->id]);
						} else {
							return $model->username;
						}
					},
					'format' => 'raw'
				],
				[
					'label' => 'Тип цен',
					'value' => function ($model) {
						return $model->profile->type == 2 ? 'Мелкий опт' : 'Опт';
					}
				],
				[
					'attribute' => 'cart_sum',
					'label' => 'Сумма',
					'format' => 'raw',
					'value' => function ($model) {
						return (int)$model->cart_sum;
					}
				],
				[
					'label' => 'Корзина',
					'value' => function ($model) {
						return Html::a("Смотреть содержимое корзины", ['/adminka/bigcart/cart', 'id' => $model->id]);
					},
					'format' => 'raw'
				]
			]
		]) ?>
	</div>
</div>