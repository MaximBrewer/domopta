<?php
/* @var $this \yii\web\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */

use yii\grid\GridView;
use yii\helpers\Html;
?>
<div class="container">
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
						return Html::a($model->username, ['/user/adminka/update', 'id' => $model->id]);
					} else {
						return $model->username;
					}
				},
				'format' => 'raw'
			],
			// [
			// 	'label' => 'Сумма',
			// 	'value' => function ($model) {
			// 		return $model->getCartSum();
			// 	}
			// ],
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