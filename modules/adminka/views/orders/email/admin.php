<?php

/**
 * @var $this \yii\web\View
 * @var $order \app\models\Order
 */

use app\models\Order;
use yii\helpers\Url;
use app\models\Products;

$types = [
    '1' => 'Опт',
    '2' => 'Мелкий Опт',
    '3' => 'Опт',
];
?>
<div style="margin:0 auto;max-width:992px;">
    <table style="width: 100%;">
        <tr>
            <td style="font-size:15px">
                <?php if (isset($status) && $status == 'canceled') : ?>
                    <div style="font-size: 24px; font-weight: bold;text-transform:uppercase;color:red;">
                        Данный заказ отменён
                    </div>
                <?php endif; ?>
                <?php if ($order->user->profile->type == 3) : ?>
                    <div style="font-size: 24px; font-weight: bold;text-transform:uppercase;">
                        ООО <?php echo str_replace("ООО", "", $order->user->profile->organization_name); ?>
                        <span style="font-weight: bold">(<?php echo $types[$order->user->profile->type] ?>)</span>
                    </div>
                    <div style="font-size: 21px; font-weight: bold;text-transform:uppercase;">
                        <?php echo $order->user->profile->lastname ?> <?php echo $order->user->profile->name ?> <?php echo $order->user->profile->surname ?>
                    </div>
                <?php else : ?>
                    <div style="font-size: 24px; font-weight: bold;text-transform:uppercase;">
                        <?php echo $order->user->profile->lastname ?> <?php echo $order->user->profile->name ?> <?php echo $order->user->profile->surname ?>
                        <span style="font-weight: bold">(<?php echo $types[$order->user->profile->type] ?>)</span>
                    </div>
                <?php endif; ?>
                <br />
                <table style="width: 100%;">
                    <tr>
                        <td>
                            <?php echo $order->user->profile->city; ?>, <?php echo $order->user->profile->region; ?>
                        </td>
                        <td style="text-align:right;">
                            Заказ № <?php echo $order->num ?> от <?php echo Yii::$app->formatter->asDate($order->created_at, 'php:d.m.Y') ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <table style="width: 100%;font-size: 14px; ">
        <tr style="vertical-align: top;">
            <td style="padding-right:20px;width:40%;">
                <table style="vertical-align: top;" width="100%">
                    <tr>
                        <td style="font-size: 22px; font-weight:500;padding-bottom:8px;">
                            <?php

                            $r = str_split($order->user->username, 1);

                            echo $r[0] . $r[1] . " (" . $r[2] . $r[3] . $r[4] . ") " . $r[5] . $r[6] . $r[7] . "-" . $r[8] . $r[9] . "-" . $r[10] . $r[11]
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php if ($order->user->profile->type == 3) : ?>
                                ИНН ООО: <?php echo $order->user->profile->inn; ?>
                            <?php elseif ($order->user->profile->type == 1) : ?>
                                ИНН ИП: <?php echo $order->user->profile->inn; ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-decoration: underline;">
                            <?php echo $order->user->email; ?>
                        </td>
                    </tr>
                    <?php if ($order->delivery_method) : ?>
                        <tr>
                            <td style="font-weight:bold;">
                                <?php echo Order::$methods[$order->delivery_method]; ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                    <?php if ($order->tc && $order->tc != 'other') : ?>
                        <tr>
                            <td style="font-size: 15px; ">
                                <?php echo Order::$tcs[$order->tc]; ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                    <?php if ($order->tc && $order->tc == 'other') : ?>
                        <tr>
                            <td style="font-size: 15px; ">
                                <?php echo $order->tc_name; ?><br>
                                (<?php if ($order->city) : ?><?php echo $order->city; ?><?php if ($order->region) : ?>, <?php echo $order->region; ?><?php endif; ?><?php endif; ?>)
                            </td>
                        </tr>
                    <?php endif; ?>
                    <?php if ($order->locality) : ?>
                        <tr>
                            <td>
                                <?php echo $order->locality; ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                    <?php if ($order->fio) : ?>
                        <tr>
                            <td>
                                <h3 style="margin:.3rem 0;padding:0;">Получатель заказа:</h3>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $order->fio; ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                    <?php if ($order->phone) : ?>
                        <tr>
                            <td>
                                <?php echo $order->phone; ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                    <?php if ($order->passport_series) : ?>
                        <tr>
                            <td>
                                Паспорт: <?php echo $order->passport_series; ?> <?php echo $order->passport_id; ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                    <?php if ($order->user->profile->order_comment) : ?>
                        <tr>
                            <td style="font-size: 15px; font-weight: bold;text-transform:uppercase;">
                                <?php echo $order->user->profile->order_comment; ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                </table>
            </td>
            <td style="width:60%;">
                <table width="100%;" style="border: 1px solid grey; border-collapse: collapse; width: 100%;margin-top:24px;">
                    <tr style="text-align: center; font-weight: bold;">
                        <td style="border: 1px solid grey" width="60%">Категория</td>
                        <td style="border: 1px solid grey" width="20%">Кол-во</td>
                        <td style="border: 1px solid grey" width="20%">Сумма</td>
                    </tr>
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
                        $arr[$cat_name]['amount'] = $arr[$cat_name]['amount'] + ($detail->amount * ($detail->product->pack_quantity ? $detail->product->pack_quantity : 1));
                        $arr[$cat_name]['sum'] = $arr[$cat_name]['sum'] + $detail->sum;
                        $total += $detail->sum;
                        if ($detail->product->ooo) {
                            $total_o += $detail->sum;
                        } else {
                            $total_t += $detail->sum;
                        }
                    }
                    ?>
                    <?php foreach ($arr as $k => $v) : ?>
                        <tr>
                            <td style="border: 1px solid grey; padding-right: 10px;padding-left: 5px;"><?php echo $k; ?></td>
                            <td style="border: 1px solid grey; text-align: center;"><?php echo $v['amount']; ?></td>
                            <td style="border: 1px solid grey; text-align: center;padding-left:5px;padding-right:5px;"><?php echo Products::formatEmailPrice($v['sum']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td style="border: 1px solid grey; text-align: right; padding-right: 10px;">Общая сумма</td>
                        <td style="border: 1px solid grey"></td>
                        <td style="border: 1px solid grey; text-align: center;padding-left:5px;padding-right:5px;"><?php echo Products::formatEmailPrice($total); ?></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <table style="font-size: 12px; border: 1px solid #333; border-collapse:collapse; margin-top: 20px ;" border="1" cellpadding="4" cellspacing="0" width="100%">
        <tr align="center" style="font-weight: bold;">
            <td width="1%" valign="middle" align="center">№</td>
            <td width="25%" valign="middle" align="center">Товар</td>
            <td width="1%" valign="middle" align="center"></td>
            <td width="10%" valign="middle" align="center">Артикул</td>
            <td width="7%" valign="middle" align="center">Цвет</td>
            <td valign="middle" align="center">Примечание</td>
            <td width="5%" valign="middle" align="center">Шт. в уп.</td>
            <td width="7%" valign="middle" align="center">Цена за уп.</td>
            <td width="7%" valign="middle" align="center">Цена за шт.</td>
            <td width="7%" valign="middle" align="center">Кол-во</td>
            <td width="10%" valign="middle" align="center">Сумма</td>
        </tr>
        <?php $cat = ''; ?>
        <?php
        $old = false;
        foreach ($details as $i => $detail) : ?>
            <tr>

                <?php
                if (!$detail->product->category) {
                    $cat_name = "Без категории";
                } else {
                    $cat_name = $detail->product->category->name;
                }
                if ($cat_name != $cat) :
                    $cat = $cat_name;
                ?>
                    <td colspan="11" style="padding: 8px;"><?php
                                                            //if($cat->parent){
                                                            //echo mb_strtoupper($cat->parent->name) . ' - ';
                                                            //}
                                                            echo mb_strtoupper($cat);
                                                            ?></td>
            </tr>
            <tr>
            <?php endif; ?>
            <td align="center"><?php echo $i + 1 ?></td>
            <td style="padding: 3px;"><?php echo $detail->name ?></td>
            <td align="center"><?php echo $detail->product->ooo ? 'О' : 'Т' ?></td>
            <td><b style="font-size: 13px;"><?php echo $detail->product->article ?></b></td>
            <td><?php echo $detail->color == 'default' ? '' : $detail->color; ?></td>
            <td><?php if ($old != $detail->order_id . '___' . $detail->article) echo $detail->memo ?></td>
            <td align="center"><?php echo $detail->product->pack_quantity ? $detail->product->pack_quantity : '' ?></td>
            <?php if (Yii::$app->user->identity->profile->type == 2) : ?>
                <td align="center"><?php echo (int) $detail->product->pack_price2 ? Products::formatEmailPrice($detail->product->pack_price2) : ''; ?></td>
            <?php else : ?>
                <td align="center"><?php echo (int) $detail->product->pack_price ? Products::formatEmailPrice($detail->product->pack_price) : ''; ?></td>
            <?php endif; ?>
            <td align="center"><?php echo Products::formatEmailPrice($detail->price); ?></td>
            <td align="center" style="font-weight: bold;"><?php echo $detail->amount ?></td>
            <td align="center" style="padding: 3px;"><?php echo Products::formatEmailPrice($detail->sum); ?></td>
            </tr>
        <?php
            $old = $detail->order_id . '___' . $detail->article;
        endforeach; ?>
    </table>
    <br />
    <div align="right"><strong>Итого:&nbsp;&nbsp;&nbsp;</strong><span style="letter-spacing: 1px; font-size: 15px;"><?php echo Products::formatEmailPrice($total, true); ?></span></div>
    <div align="left">
        <p>Итого, О:&nbsp;&nbsp;&nbsp;<?php echo Products::formatEmailItog($total_o, true); ?></p>
        <p>Итого, Т:&nbsp;&nbsp;&nbsp;<?php echo Products::formatEmailItog($total_t, true); ?></p>
    </div>
</div>