<?php

/**
 * @var $searchModel \app\models\OrderSearch
 * @var $dataProvider \yii\data\ActiveDataProvider
 */

use app\models\OrderReestrForm;
use yii\grid\GridView;
use yii\grid\CheckboxColumn;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;
?>
<div class="container">
    <h2>Заказы</h2>
    <div class="form-group">
        <?php if (\Yii::$app->user->identity->role == 'admin') : ?>
            <?= Html::a('Удалить выбранные', '#', ['class' => 'btn btn-danger', 'data-toggle' => 'modal', 'data-target' => '#delete-modal']) ?>
        <?php endif; ?>
        <?php
        Modal::begin([
            'id' => 'reestr-modal',
            'header' => 'Укажите период для Реестра',
            'toggleButton' => [
                'label' => 'Скачать реестр заказов (XLS)',
                'class' => 'btn btn-success'
            ],
        ]);
        echo $this->render('/orders/_reestr', ['model' => new OrderReestrForm()]);
        Modal::end();
        ?>
    </div>
    <?= Html::beginForm(['delete'], 'post', ['id' => 'orders-multiply-form']) ?>
    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'layout' => '{summary} {pager} {items} {pager}',
        'rowOptions' => function ($model) {
            return ['class' => "order-status-" . $model->status];
        },
        'columns' => [
            [
                'class' => CheckboxColumn::class
            ],
            [
                'class' => ActionColumn::class,
                'template' => '{update}',
            ],
            [
                'attribute' => 'num',
                'value' => function ($model) {
                    return (string) $model->num;
                },
            ],
            [
                'label' => 'ФИО',
                'value' => function ($model) {
                    if ($model->user && $model->user->profile) {
                        return implode(' ', [
                            $model->user->profile->lastname,
                            $model->user->profile->name,
                            $model->user->profile->surname,
                        ]);
                    }
                },
                'attribute' => 'name'
            ],
            [
                'attribute' => 'ooo',
                'value' => 'user.profile.organization_name',
                'value' => function ($model) {
                    return (string) $model->user->profile->organization_name;
                },
            ],
            [
                'attribute' => 'sum',
                'value' => function ($model) {
                    return Yii::$app->formatter->asDecimal($model->sum, 2);
                },
                'format' => 'raw',
                'contentOptions' => ['class' => 'text-right']
            ],
            [
                'attribute' => 'created_at',
                'value' => function ($model) {
                    return date('d.m.Y H:i', $model->created_at);
                }
            ],
        ]
    ]); ?>
    <?php Modal::begin([
        'id' => 'delete-modal',
        'header' => 'Удалить выбранные'
    ]) ?>
    <p>Вы действительно хотите удалить выбранные заказы?</p>
    <div class="form-group">
        <?php echo Html::a('Отмена', '#', ['class' => 'btn btn-default', 'data-dismiss' => 'modal']); ?>
        <?php echo Html::submitInput('Удалить выбранные', ['class' => 'btn btn-success']); ?>
    </div>
    <?php Modal::end(); ?>
    <?php Html::endForm(); ?>
</div>