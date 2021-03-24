<?php
/**
 * @var $this \yii\web\View
 * @var $order \app\models\Order
 */
use yii\helpers\Html;
use yii\helpers\Url;
$types = [
    'ip' => 'ИП',
    'ooo' => 'ООО',
    'sp' => 'СП'
];
?>
<table style="font-family: Arial">
    <tr>
        <td>
            Заказ №<?php echo $order->id ?> от <?php echo Yii::$app->formatter->asDate($order->created_at, 'php:d.m.Y') ?>
            <br />
            <span style="font-weight: bold; font-size: 24px">
                <?php echo $order->user->profile->lastname ?> <?php echo $order->user->profile->name ?> <?php echo $order->user->profile->surname ?>
            </span>
            (<?php echo $types[$order->user->profile->type] ?>)
        </td>
    </tr>
</table>
<?php $details = $order->getDetiles()->joinWith('product')->orderBy(['category_id' => SORT_ASC, 'article_index' => SORT_ASC])->all();
$arr = [];
$total = 0;
foreach ($details as $detail){
    $total += $detail->sum;
}
?>
<br />
<br />
<table style="font-family: Arial; width: 100%; border-collapse: collapse;" border="1">
    <tr align="center" style="font-weight: bold;">
        <td style="padding: 10px 3px;">Артикул</td>
        <td>Фото</td>
        <td>Цвет</td>
        <td>Цена за 1 шт.</td>
        <td>Штук в уп.</td>
        <td>кол-во</td>
        <td>сумма</td>
        <td>примечание</td>
    </tr>
    <?php $cat = ''; ?>
    <?php foreach ($details as $i => $detail): ?>
        <tr>
            <td style="padding: 3px;"><?php echo $detail->article ?></td>
            <td align="center"><?php echo Html::img( Url::base(true) . (isset($detail->product->pictures[0])?$detail->product->pictures[0]->getUrl('small'):'/images/gj_146x187.jpg')) ?></td>
            <td style="padding: 3px;"><?php echo $detail->color ?></td>
            <td align="center"><?php echo (int)$detail->price ?> руб.</td>
            <td align="center"><?php echo $detail->product->pack_quantity?$detail->product->pack_quantity:1 ?></td>
            <td align="center"><?php echo $detail->amount ?></td>
            <td align="right" style="padding: 3px;"><?php echo (int)$detail->sum ?> руб.</td>
            <td><?php echo $detail->memo ?></td>
        </tr>
    <?php endforeach; ?>
</table>
<br />
<table style="font-family: Arial; width: 100%;">
    <tr>
        <td align="right" style="font-size: 18px;"><strong>Итого: </strong><?php echo $total ?> руб.</td>
    </tr>
</table>