<?php
/* @var $this \yii\web\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */

use yii\grid\GridView;
use yii\helpers\Html;
?>
<div class="container">
	<?php echo $this->render('../_alert', ['module' => \Yii::$app->getModule('user')]); ?>
	<div class="nouse">
		<?php echo Html::a("Оформить заказ", ['/' . MODULE_ID . '/bigcart/order', 'id' => $user->id], ['class' => 'btn btn-primary btn-sm']); ?><br /><br />
		<?php echo $user->renderBigCart() ?><br />
		<?php echo Html::a("Оформить заказ", ['/' . MODULE_ID . '/bigcart/order', 'id' => $user->id], ['class' => 'btn btn-primary btn-sm']); ?>
	</div>
</div>