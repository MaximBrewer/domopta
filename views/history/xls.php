<?php
/* @var $this \yii\web\View */
/* @var $order \app\models\Order */

use app\models\Products;
use app\models\User;

$products = [];
foreach ($order->detiles as $item) {
	if (!$item->product) continue;
	$products[$item->product->id]['product'] = $item->product;
	$products[$item->product->id]['colors'][] = $item;
}
?>
<table cellpadding="5" border="1">
	<thead>
		<tr>
			<th style="font-size:14pt;font-weight:bold" colspan="10">Заказ № <?php echo $order->id; ?> от <?php echo date("d.m.Y", $order->created_at); ?></th>
		</tr>
		<tr>
			<th style="font-size:12pt;font-weight:bold" align="center">№</th>
			<th align="center" style="font-size:12pt;font-weight:bold">Товар</th>
			<th align="center" style="font-size:12pt;font-weight:bold">Артикул</th>
			<th align="center" style="font-size:12pt;font-weight:bold">Цвет</th>
			<th align="center" style="font-size:12pt;font-weight:bold">Примечание</th>
			<th align="center" style="font-size:12pt;font-weight:bold">Шт. в уп.</th>
			<th align="center" style="font-size:12pt;font-weight:bold">Цена за уп.</th>
			<th align="center" style="font-size:12pt;font-weight:bold">Цена за шт.</th>
			<th align="center" style="font-size:12pt;font-weight:bold">Кол-во</th>
			<th align="center" style="font-size:12pt;font-weight:bold">Сумма</th>
		</tr>
	</thead>
	<tbody style="font-size:12pt;font-weight:bold">

		<?php $details = $order->getDetiles()->joinWith('product')->orderBy(['category_id' => SORT_ASC, 'article_index' => SORT_ASC])->all();
		$arr = [];
		$total = 0;
		$total_o = 0;
		$total_t = 0;
		foreach ($details as $detail) {
			//$cat_name = $detail->product->category->parent?$detail->product->category->parent->name . ' - ':'';
			if (!$detail->product->category) {
				$cat_name = 'Без категории';
			} else {
				$cat_name = $detail->product->category->name;
			}
			$cat_name = mb_strtoupper($cat_name);
			if (!isset($arr[$cat_name])) {
				$arr[$cat_name] = [
					'amount' => 0,
					'sum' => 0
				];
			}
			$arr[$cat_name]['amount'] = $arr[$cat_name]['amount'] + $detail->amount;
			$arr[$cat_name]['sum'] = $arr[$cat_name]['sum'] + $detail->sum;
			$arr[$cat_name]['details'][] = $detail;
			$total += $detail->sum;
			if ($detail->product->ooo) {
				$total_o += $detail->sum;
			} else {
				$total_t += $detail->sum;
			}
		}
		$cnt = 0;

		foreach ($arr as $k => $v) : ?>
			<tr>
				<td colspan="10"><?php echo $k; ?></td>
			</tr>
			<?php foreach ($v['details'] as $d) : $cnt++; ?>
				<tr>
					<td align="center"><?php echo $cnt; ?></td>
					<td align="left" width="40"><?php echo $d->name; ?></td>
					<td align="left" width="15"><?php echo $d->product->article; ?></td>
					<td align="left" width="15"><?php echo $d->color == 'default' ? '' : $d->color; ?></td>
					<td align="left" width="20"><?php echo $d->memo; ?></td>
					<td width="12" align="center"><?php echo $d->product->pack_quantity ? $d->product->pack_quantity : 1 ?></td>
					<?php if ($order->user->profile->type == 2) : ?>
						<td width="12" align="center"><?php echo (int) $d->product->pack_price2 ? Products::formatEmailPrice($d->product->pack_price2) : ''; ?></td>
					<?php else : ?>
						<td width="12" align="center"><?php echo (int) $d->product->pack_price ? Products::formatEmailPrice($d->product->pack_price) : ''; ?></td>
					<?php endif; ?>
					<td width="12" align="center"><?php echo $d->price; ?></td>
					<td width="12" align="center"><?php echo $d->amount; ?></td>
					<td width="12" align="center"><?php echo Products::formatEmailPrice($d->sum); ?></td>
				</tr>
			<?php endforeach; ?>
		<?php endforeach; ?>
		<tr>
			<td colspan="10" style="font-size:14pt;font-weight:bold" align="right">Итого: <?php echo Products::formatEmailPrice($total, true); ?></td>
		</tr>
	</tbody>
</table>