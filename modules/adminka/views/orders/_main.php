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
<?php if (\Yii::$app->user->identity->role == 'admin') : ?>
    <div class="form-group">
        <?php echo Html::a('Печать', ['print', 'id' => $order->id], ['class' => 'btn btn-success', 'target' => '_blank']) ?>
        <?php echo Html::a('Провести перерасчет', ['recount', 'id' => $order->id], ['class' => 'btn btn-success']) ?>
        <?php echo Html::a('Вернуть к последнему перерасчету', ['recountcancel', 'id' => $order->id], ['class' => 'btn btn-success']) ?>
    </div>
<?php endif; ?>

<?php $this->beginBlock('total'); ?>
<?php
$old_sum = $order->getOldSum();
$sum = $order->getSum();
?>
<?php if (is_float($old_sum) && $old_sum != $sum) : ?>
    <s><strong><?php echo Yii::$app->formatter->asDecimal($old_sum, 2); ?></strong></s><br />
<?php endif; ?>
<strong><?php echo Yii::$app->formatter->asDecimal($sum, 2); ?></strong>
<?php $this->endBlock(); ?>

<?php $this->beginBlock('total_amount'); ?>
<?php
$total_amount = $order->getAmount();
?>
<strong><?php echo $total_amount; ?></strong>
<?php $this->endBlock(); ?>

<?php
class OrderView extends GridView
{
    /**
     * Renders the table body.
     * @return string the rendering result.
     */
    public function renderTableBody()
    {
        $models = array_values($this->dataProvider->getModels());
        $keys = $this->dataProvider->getKeys();
        $rows = [];
        $old = false;
        foreach ($models as $index => $model) {

            if($old == $model->order_id . '___' . $model->article) $model->memo = '';
            $key = $keys[$index];
            
            if ($this->beforeRow !== null) {
                $row = call_user_func($this->beforeRow, $model, $key, $index, $this);
                if (!empty($row)) {
                    $rows[] = $row;
                }
            }

            $rows[] = $this->renderTableRow($model, $key, $index);

            if ($this->afterRow !== null) {
                $row = call_user_func($this->afterRow, $model, $key, $index, $this);
                if (!empty($row)) {
                    $rows[] = $row;
                }
            }
            $old = $model->order_id . '___' . $model->article;
        }

        if (empty($rows) && $this->emptyText !== false) {
            $colspan = count($this->columns);

            return "<tbody>\n<tr><td colspan=\"$colspan\">" . $this->renderEmpty() . "</td></tr>\n</tbody>";
        }

        return "<tbody>\n" . implode("\n", $rows) . "\n</tbody>";
    }
}
?>
<?php echo OrderView::widget([
    'dataProvider' => $model->search($order->id),
    'tableOptions' => [
        'class' => 'table table-bordered'
    ],
    'layout' => '{items}',
    'showFooter' => true,
    'columns' => [
        [
            'attribute' => 'article',
            'footer' => '<strong>Итого:</strong>',
            'value' => function ($model) {
                return $model->product->article;
            }
        ],
        'name',
        [
            'attribute' => 'color',
            'format' => 'raw',
            'value' => function ($model) {
                return $model->color == 'default' ? '' : $model->color;
            }
        ],
        [
            'attribute' => 'memo',
            'format' => 'raw',
            'value' => function ($model) {
                return $model->memo ? $model->memo : '';
            }
        ],
        [
            'attribute' => 'amount',
            'label' => 'Кол-во',
            'contentOptions' => ['class' => 'text-center'],
            'value' => function ($model) {
                return $model->amount ? $model->amount : '';
            },
            'footer' => $this->blocks['total_amount'],
            'contentOptions' => ['class' => 'text-right'],
            'footerOptions' => ['class' => 'text-right'],
        ],
        [
            'attribute' => 'price',
            'format' => 'raw',
            'value' => function ($model) {
                $str = '';
                if ($model->price_old && $model->price_old != $model->price) {
                    $str .= '<s>' . Yii::$app->formatter->asDecimal($model->price_old, 2) . '</s><br />';
                }
                return $str . Yii::$app->formatter->asDecimal($model->price, 2);
            },
            'contentOptions' => ['class' => 'text-right']
        ],
        [
            'attribute' => 'sum',
            'format' => 'raw',
            'value' => function ($model) {
                $str = '';
                if ($model->sum_old && $model->sum_old != $model->sum) {
                    $str .= '<s>' . Yii::$app->formatter->asDecimal($model->sum_old, 2) . '</s><br />';
                }
                return $str . Yii::$app->formatter->asDecimal($model->sum, 2);
            },
            'footer' => $this->blocks['total'],
            'contentOptions' => ['class' => 'text-right'],
            'footerOptions' => ['class' => 'text-right'],
        ],
    ],
    'rowOptions' => function ($model, $key, $index, $grid) {
        return [
            // 'style' => !$model->flag ? 'text-decoration:line-through' : '',
            'class' => !$model->flag ? 'absend strikeout' : ''
        ];
    }

]); ?>