<?php
/* @var $this \yii\web\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */

use yii\grid\GridView;
use yii\helpers\Html;
?>
<style>
	table td,
	table th {
		border: 1px solid black;
	}
</style>
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
			'label' => 'Сумма',
			'value' => function ($model) {
				return $model->getCartSum();
			}
		],
		[
			'label' => 'Время последнего добавления товара в Корзину',
			'value' => function ($model) {
				return $model->getLastCartAdd();
			},
			'format' => 'raw'
		]
	]
]) ?>