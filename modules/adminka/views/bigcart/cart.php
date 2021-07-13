<?php
/* @var $this \yii\web\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */

use yii\grid\GridView;
use yii\helpers\Html;
?>
<div class="container">
<div class="nouse">
	<?php echo Html::a("Оформить заказ", ['/adminka/bigcart/order', 'id' => $user->id], ['class' => 'btn btn-primary btn-sm']) ;?><br/><br/>
	<?php echo $user->renderBigCart() ?><br/>
	<?php echo Html::a("Оформить заказ", ['/adminka/bigcart/order', 'id' => $user->id], ['class' => 'btn btn-primary btn-sm']) ;?>
</div>
</div>