<?php
/**
 * @var $this \yii\web\View
 * @var $dataProvider \yii\data\ActiveDataProvider
 * @var $model \app\models\Menu
 * @var $form \yii\widgets\ActiveForm
 */
use yii\grid\GridView;
use yii\helpers\Html;
use yii\grid\ActionColumn;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Page;
?>
<h2>Редактирование меню</h2>

<?php $form = ActiveForm::begin() ?>
<?php echo $form->field($model, 'page_id')
    ->dropDownList(['-- выбирите --'] + ArrayHelper::map(Page::findAll(['status' => 1]), 'id', 'name')) ?>
<?php echo $form->field($model, 'order'); ?>
<div class="form-group">
    <?php echo Html::submitInput('Добавить пункт меню', ['class' => 'btn btn-success']); ?>
</div>
<?php ActiveForm::end(); ?>
<?php echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'class' => ActionColumn::className(),
            'template' => '{update} {delete}'
        ],
        'page.name',
        'order'
    ]
]); ?>
