<?php
/**
 * @var $this \yii\web\View
 * @var $order \app\models\Order
 */
use app\models\Products;
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
<table style="font-family: Arial; width: 100%;">
    <tr>
        <td width="50%">
            <table style="vertical-align: top;">
                <tr>
                    <td>
                        ИНН ИП: <?php echo $order->user->profile->inn ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php echo $order->user->profile->city ?>, <?php echo $order->user->profile->region ?>
                    </td>
                </tr>
                <tr>
                    <td style="text-decoration: underline;">
                        <?php echo $order->user->email ?>
                    </td>
                </tr>
            </table>
        </td>
        <td width="50%" style="vertical-align: top">
            <table width="100%;" border="1" style="border-collapse: collapse;">
                <tr style="text-align: center; font-weight: bold;">
                    <td>Категория</td>
                    <td>Кол-во</td>
                    <td>Сумма</td>
                </tr>
                <?php $details = $order->getDetiles()->joinWith('product')->orderBy(['category_id' => SORT_ASC, 'article_index' => SORT_ASC])->all();
                    $arr = [];
                    $total = 0;
                    foreach ($details as $detail){
                        if(!isset($arr[$detail->product->category->name])){
                            $arr[$detail->product->category->name] = [
                                    'amount' => 0,
                                    'sum' => 0
                            ];
                        }
                        $arr[$detail->product->category->name]['amount'] = $arr[$detail->product->category->name]['amount'] + $detail->amount;
                        $arr[$detail->product->category->name]['sum'] = $arr[$detail->product->category->name]['sum'] + $detail->sum;
                        $total += $detail->sum;
                    }
                ?>
                <?php foreach ($arr as $k => $v):?>
                    <tr>
                        <td style="padding: 3px;"><?php echo $k; ?></td>
                        <td align="center"><?php echo $v['amount']; ?></td>
                        <td align="right" style="padding: 3px;"><?php echo Products::formatEmailPrice($v['sum'], true);?></td>
                    </tr>
                <?php endforeach; ?>
                    <tr>
                        <td align="right" style="padding: 3px;">Общая сумма</td>
                        <td></td>
                        <td align="right" style="padding: 3px;"><?php echo Products::formatEmailPrice($total, true);?></td>
                    </tr>
            </table>
        </td>
    </tr>
</table>
<br />
<br />
<table style="font-family: Arial; width: 100%; border-collapse: collapse;" border="1">
    <tr align="center" style="font-weight: bold;">
        <td style="padding: 10px 3px;">№</td>
        <td>Товар</td>
        <td></td>
        <td>Модель</td>
        <td>Цвет / Размер</td>
        <td>Примечание</td>
        <td>Шт. в уп.</td>
        <td>Цена за уп.</td>
        <td>Цена за шт.</td>
        <td>Кол-во</td>
        <td>Сумма</td>
    </tr>
    <?php $cat = ''; ?>
    <?php foreach ($details as $i => $detail): ?>
        <tr>

        <?php if($detail->product->category->name != $cat):
            $cat = $detail->product->category->name;
            ?>
            <td colspan="11" style="padding: 3px;"><?php echo $cat; ?></td>
            </tr>
            <tr>
        <?php endif; ?>
            <td align="center"><?php echo $i+1 ?></td>
            <td style="padding: 3px;"><?php echo $detail->name ?></td>
            <td align="center"><?php echo $detail->product->ooo?'О':'Т' ?></td>
            <td style="padding: 3px;"><?php echo $detail->article ?></td>
            <td style="padding: 3px;"><?php echo $detail->color ?></td>
            <td><?php echo $detail->memo ?></td>
            <td align="center"><?php echo $detail->product->pack_quantity?$detail->product->pack_quantity:1 ?></td>
            <td align="center"><?php echo Products::formatEmailPrice((int)($detail->product->pack_price?$detail->product->pack_price:$detail->product->price), true);?></td>
            <td align="center"><?php echo Products::formatEmailPrice((int)$detail->price, true);?></td>
            <td align="center"><?php echo $detail->amount ?></td>
            <td align="right" style="padding: 3px;"><?php echo Products::formatEmailPrice((int)$detail->sum, true);?></td>
        </tr>
    <?php endforeach; ?>
</table>
<br />
<table style="font-family: Arial; width: 100%;">
    <tr>
        <td align="right" style="font-size: 18px;"><strong>Итого: </strong><?php echo Products::formatEmailPrice($total, true);?></td>
    </tr>
</table>