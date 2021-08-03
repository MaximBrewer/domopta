<?php

/**
 * @var $this \yii\web\View
 * @var $searchModel \app\models\NewsSearch
 * @var $dataProvider \yii\data\ActiveDataProvider
 */

use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\bootstrap\Html;
?>
<div class="container">
    <?php echo $this->render('../_alert', ['module' => \Yii::$app->getModule('user')]); ?>
    <h2>Новости</h2>
    <div class="form-group">
        <?php echo Html::a('Добавить', ['add'], ['class' => 'btn btn-success']); ?>
    </div>
    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'class' => ActionColumn::class,
                'template' => \Yii::$app->user->identity->role == 'admin' ? '{update} {delete}' : '{update}',
            ],
            [
                'attribute' => 'created_at',
                'value' => function ($model) {
                    return date('d.m.Y H:i', $model->created_at);
                }
            ],
            'name'
        ]
    ]) ?>
</div>