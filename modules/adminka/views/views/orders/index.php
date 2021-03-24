<?php
/**
 * @var $searchModel \app\models\OrderSearch
 * @var $dataProvider \yii\data\ActiveDataProvider
 */
use yii\grid\GridView;
use yii\grid\CheckboxColumn;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;
?>
<h2>Заказы</h2>
<?= Html::beginForm(['delete'], 'post', ['id' => 'orders-multiply-form']) ?>
<div class="form-group">
    <?= Html::a('Удалить выбранных', '#' ,['class' => 'btn btn-danger', 'data-toggle' => 'modal', 'data-target' => '#delete-modal']) ?>
</div>
<?php echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'layout' => '{pager} {items} {pager}',
    'columns' => [
            [
                    'class' => CheckboxColumn::className()
            ],
            [
                    'class' => ActionColumn::className(),
                    'template' => '{update}',
            ],
            'id',
            [
                    'label' => 'ФИО',
                    'value' => function($model){
                        if($model->user){
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
                    'value' => function($model){
                        if($model->user){
                            return $model->user->profile->organization_name;
                        }
                    }
            ],
            'sum',
            'created_at:datetime'
    ]
]); ?>
<?php Modal::begin([
    'id' => 'delete-modal',
    'header' => 'Удалить выбранне'
]) ?>
    <p>Вы действительно хотите удалить выбранне заказы?</p>
    <div class="form-group">
        <?php echo Html::a('Отмена', '#',['class' => 'btn btn-default', 'data-dismiss' => 'modal']); ?>
        <?php echo Html::submitInput('Удалить', ['class' => 'btn btn-success']); ?>
    </div>
<?php Modal::end(); ?>
<?php Html::endForm(); ?>


