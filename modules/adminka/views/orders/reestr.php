<?php
/* @var $this \yii\web\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */

use app\models\Order;
use yii\grid\GridView;
use yii\helpers\Html;
?>


<table cellpadding="10" border="1" width="100%" style="font-size:11pt;word-wrap:break-word;">
	<thead>
		<tr style="vertical-align:center;">
			<th colspan="8" align="center" valign="center" style="font-size:14pt;">Реестр заказов за период с <?php echo $from; ?> по <?php echo $to; ?></th>
		</tr>
		<tr>
			<th colspan="8">&nbsp;</th>
		</tr>
		<tr style="vertical-align:center;">
			<th width="6" align="center" valign="center" style="border: 1px solid black;font-size:12pt;font-weight:bold">Заказ</th>
			<th width="12" align="center" valign="center" style="border: 1px solid black;font-size:12pt;font-weight:bold">Дата</th>
			<th width="24" align="center" valign="center" style="border: 1px solid black;font-size:12pt;font-weight:bold">ФИО </th>
			<th width="16" align="center" valign="center" style="border: 1px solid black;font-size:12pt;font-weight:bold">Город</th>
			<th width="16" align="center" valign="center" style="border: 1px solid black;font-size:12pt;font-weight:bold">Область</th>
			<th width="20" align="center" valign="center" style="border: 1px solid black;font-size:12pt;font-weight:bold">Телефон</th>
			<th width="12" align="center" valign="center" style="border: 1px solid black;font-size:12pt;font-weight:bold">Тип цен</th>
			<th width="12" align="center" valign="center" style="border: 1px solid black;font-size:12pt;font-weight:bold">Сумма</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$cnt = 0;
		foreach ($orders as $k => $model) : ?>
			<tr style="vertical-align:center;">
				<td valign="center" align="center" style="border: 1px solid black;"><?php echo $model->num; ?></td>
				<td valign="center" align="center" style="border: 1px solid black;"><?php echo $model->date; ?></td>
				<td valign="center" align="center" style="border: 1px solid black;white-space:nowrap;"><?php echo $model->user->profile->lastname . ' ' . $model->user->profile->name . ' ' . $model->user->profile->surname; ?></td>
				<td valign="center" align="center" style="border: 1px solid black;">
					<?php
					echo in_array($model->delivery_method, ['pickup', 'unknown']) ? Order::$methods[$model->delivery_method] : ($model->city ? $model->city : $model->locality);
					?>
				</td>
				<td valign="center" align="center" style="border: 1px solid black;"><?php echo $model->region; ?></td>
				<td valign="center" align="center" style="border: 1px solid black;white-space:nowrap;"><?php echo $model->phone; ?></td>
				<td valign="center" align="center" style="border: 1px solid black;"><?php echo $model->user->profile->type == 2 ? 'Мелкий опт' : 'Опт' ?></td>
				<td valign="center" align="center" style="border: 1px solid black;"><?php echo $model->sum; ?></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>