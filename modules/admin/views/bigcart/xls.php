<?php
/* @var $this \yii\web\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */

use yii\grid\GridView;
use yii\helpers\Html;
?>


<table cellpadding="10" border="1" width="100%" style="font-size:11pt;word-wrap:break-word;">
	<thead>
		<tr style="vertical-align:center;">
			<th width="6" align="center" valign="center" style="border: 1px solid black;font-size:12pt;font-weight:bold">№</th>
			<th width="24" align="center" valign="center" style="border: 1px solid black;font-size:12pt;font-weight:bold">ФИО </th>
			<th width="16" align="center" valign="center" style="border: 1px solid black;font-size:12pt;font-weight:bold">Город</th>
			<th width="16" align="center" valign="center" style="border: 1px solid black;font-size:12pt;font-weight:bold">Область</th>
			<th width="16" align="center" valign="center" style="border: 1px solid black;font-size:12pt;font-weight:bold">Телефон</th>
			<th width="12" align="center" valign="center" style="border: 1px solid black;font-size:12pt;font-weight:bold">Тип цен</th>
			<th width="12" align="center" valign="center" style="border: 1px solid black;font-size:12pt;font-weight:bold">Сумма</th>
			<th width="20" align="center" valign="center" style="border: 1px solid black;font-size:12pt;font-weight:bold">Время последнего добавления<br>товара в корзину</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$cnt = 0;
		foreach ($users as $k => $model) : ?>
			<tr style="vertical-align:center;">
				<td valign="center" align="center" style="border: 1px solid black;"><?php echo ++$cnt; ?></td>
				<td valign="center" align="center" style="border: 1px solid black;"><?php echo $model->profile->lastname . ' ' . $model->profile->name . ' ' . $model->profile->surname; ?></td>
				<td valign="center" align="center" style="border: 1px solid black;"><?php echo $model->profile->city; ?></td>
				<td valign="center" align="center" style="border: 1px solid black;"><?php echo $model->profile->region; ?></td>
				<td valign="center" align="center" style="border: 1px solid black;"><?php echo $model->username; ?></td>
				<td valign="center" align="center" style="border: 1px solid black;"><?php echo $model->profile->type == 2 ? 'Мелкий опт' : 'Опт' ?></td>
				<td valign="center" align="center" style="border: 1px solid black;"><?php echo $model->cart_sum; ?></td>
				<td valign="center" align="center" style="border: 1px solid black;"><?php echo $model->getLastCartAdd(); ?></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>