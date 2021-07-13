<?php
/* @var $this \yii\web\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */


use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\CheckboxColumn;
use yii\grid\ActionColumn;
use yii\bootstrap\Modal;
use execut\widget\TreeView;
use yii\helpers\Url;
use app\models\Products;
use yii\widgets\ActiveForm;
use yii\bootstrap\Alert;
?>
<div class="container">
	<div class="text-right">
		<a href="/adminka/bigcart/xls" class="btn btn-success">Реестр Корзина от 3000 (XLS)</a>
	</div>

	<?php if ($module->enableFlashMessages) : ?>
		<div class="row">
			<div class="col-xs-12">
				<?php foreach (Yii::$app->session->getAllFlashes() as $type => $message) : ?>
					<?php if (in_array($type, ['success', 'danger', 'warning', 'info'])) : ?>
						<?= Alert::widget([
							'options' => ['class' => 'alert-dismissible alert-' . $type],
							'body' => is_array($message) ? $message[0] : $message
						]) ?>
					<?php endif ?>
				<?php endforeach ?>
			</div>
		</div>
	<?php endif ?>

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
					'class' => ActionColumn::className(),
					'template' => '{view} {order}',
					'buttons' => [
						'view' => function ($url, $model, $key) use ($category) {
							return Html::a("Смотреть содержимое корзины", ['/adminka/bigcart/cart', 'id' => $model->id], ['class' => 'btn btn-primary btn-sm']);
						},
						'order' => function ($url, $model, $key) use ($category) {
							return Html::a("Оформить заказ", ['/adminka/bigcart/order', 'id' => $model->id], ['class' => 'btn btn-primary btn-sm']);
						},
					]
				]
			]
		]) ?>
	</div>
</div>