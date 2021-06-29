<?php

/**
 * @var $this \yii\web\View
 * @var $order \app\models\Order
 */

use app\models\OrderDetailsSearch;
use yii\grid\GridView;
use yii\helpers\Html;

$model = new OrderDetailsSearch();

?>
<h3>Номер заказа: <?php echo $order->id ?></h3>
<div class="form-group">
    <?php echo Html::a('Печать', ['print', 'id' => $order->id], ['class' => 'btn btn-success', 'target' => '_blank']) ?>
    <?php echo Html::a('Пересчет цен', ['recount', 'id' => $order->id], ['class' => 'btn btn-success']) ?>
    <?php echo Html::a('Вернуть к последнему перерасчету', ['recountcancel', 'id' => $order->id], ['class' => 'btn btn-success']) ?>
</div>

<?php $this->beginBlock('total'); ?>
<?php
$old_sum = $order->getOldSum();
$sum = $order->getSum();
?>
<?php if (is_float($old_sum) && $old_sum != $sum) : ?>
    <s><strong><?php echo $old_sum; ?></strong></s><br />
<?php endif; ?>
<strong><?php echo $sum; ?></strong>
<?php $this->endBlock(); ?>

<?php echo GridView::widget([
    'dataProvider' => $model->search($order->id),
    'tableOptions' => [
        'class' => 'table table-bordered'
    ],
    'layout' => '{items}',
    'showFooter' => true,
    'columns' => [
        [
            'attribute' => 'article',
            'footer' => '<strong>Итого:</strong>'
        ],
        [
            'attribute' => 'name',
            'value' => function ($model) {
                return count($model->name);
            },
        ],
        [
            'attribute' => 'color',
            'value' => function ($model) {
                return count($model->color);
            },
        ],
        [
            'attribute' => 'memo',
            'value' => function ($model) {
                return count($model->memo);
            },
        ],
        [
            'attribute' => 'amount',
            'label' => 'Кол-во',
            'value' => function ($model) {
                return count($model->amount);
            },
        ],
        [
            'attribute' => 'price',
            'format' => 'raw',
            'value' => function ($model) {
                $str = '';
                if ($model->price_old && $model->price_old != $model->price) {
                    $str .= '<s>' . $model->price_old . '</s><br />';
                }
                return $str . $model->price;
            }
        ],
        [
            'attribute' => 'sum',
            'format' => 'raw',
            'value' => function ($model) {
                $str = '';
                if ($model->sum_old && $model->sum_old != $model->sum) {
                    $str .= '<s>' . $model->sum_old . '</s><br />';
                }
                return $str . $model->sum;
            },
            'footer' => $this->blocks['total']
        ],
    ],
    'rowOptions' => function ($model, $key, $index, $grid) {
        return [
            'style' => !$model->flag ? 'text-decoration:line-through' : ''
        ];
    }

]); ?>