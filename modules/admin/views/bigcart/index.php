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
    <div class="form-group">
        <?php if (in_array(\Yii::$app->user->identity->role, ['admin', 'manager'])) : ?>
            <?= Html::a('Реестр Корзина от 3000 (XLS)', '/'.MODULE_ID.'/bigcart/xls', ['class' => 'btn btn-success']) ?>
        <?php endif; ?>
    </div>
	<?php echo $this->render('../_alert', ['module' => \Yii::$app->getModule('user')]); ?>
	<div class="nouse">
		<?php echo GridView::widget([
			'dataProvider' => $dataProvider,
			'filterModel' => $searchModel,
			'layout' => '{summary} {pager} {items} {pager}',
			'columns' => [
				[
					'label' => 'ФИО',
					'value' => function ($model) {
						if ($model->profile) {
							return implode(' ', [
								$model->profile->lastname,
								$model->profile->name,
								$model->profile->surname,
							]);
						}
					},
					'attribute' => 'name'
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
					'attribute' => 'cart_sum',
					'label' => 'Сумма',
					'format' => 'raw',
					'value' => function ($model) {
						return (int)$model->cart_sum;
					}
				],
				[
					'class' => ActionColumn::class,
					'template' => '{view}',
					'buttons' => [
						'view' => function ($url, $model, $key) {
							return Html::a("Смотреть содержимое корзины", ['/'.MODULE_ID.'/bigcart/cart', 'id' => $model->id], ['class' => 'btn btn-link']);
						}
					]
				]
			]
		]) ?>
	</div>
</div>