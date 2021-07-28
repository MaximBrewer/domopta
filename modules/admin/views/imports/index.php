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
						return Html::a($model->username, ['/user/'.MODULE_ID.'/update', 'id' => $model->id]);
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
				'label' => 'Скачиваний за месяц',
				'value' => function ($model) {
					return $model->imports;
				}
			],
			[
				'label' => 'Дата последнего скачивания',
				'value' => function ($model) {
					return date("d.m.Y H:i", strtotime($model->lastImport));
				}
			],
		]
	]) ?>
</div>
</div>