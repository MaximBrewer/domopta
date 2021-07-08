<?php
/**
 * @var $this \yii\web\View
 * @var $category_list \app\models\Category[]
 * @var $category \app\models\Category
 * @var $searchModel \app\models\ProductsSearch
 * @var $dataProvider \yii\data\ActiveDataProvider
 * @var $form ActiveForm;
 */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\CheckboxColumn;
use yii\grid\ActionColumn;
use yii\bootstrap\Modal;
use execut\widget\TreeView;
use yii\helpers\Url;
use app\models\Products;
use yii\widgets\ActiveForm;

$this->registerJsFile('/js/catalog.js', ['depends' => \app\assets\AdminAsset::className()]);
echo $this->render('../_alert', ['module' => Yii::$app->getModule('user')]);

?>

<div class="row">
    <div class="col-md-3">
        <?php //echo $this->render('left_menu', ['category_list' => $category_list, 'searchModel' => $searchModel, 'category' => $category]) ?>
    </div>
    <div class="col-md-9">
        <?= Html::beginForm(['/adminka/catalog/deletemultiply', 'id' => $category->id], 'post', ['id' => 'deletemultiply-form']) ?>
        <?php if ($category->id): ?>
            <h3 style="margin-top:0;"><?php echo $category->name ?></h3>
            <?php if (Yii::$app->user->identity->role == 'admin'): ?>
                <?php echo Html::a('Редактировать категорию', ['updatecategory', 'id' => $category->id], ['class' => 'btn btn-success']); ?>
            <?php endif; ?>
            <?php if (Yii::$app->user->identity->role == 'admin'): ?>

                <?php
                if (empty($category->getChildren())) {
                    echo Html::a('Удалить все фото', '#', ['class' => 'btn btn-success', 'data-toggle' => 'modal', 'data-target' => '#delete-photo-modal']);
                }
                ?>
            <?php endif; ?>
            <?php echo Html::a('Показать проданные модели', ['index', 'id' => $category->id, $searchModel->formName() . '[flag]' => 0], ['class' => 'btn btn-success']); ?>
            <?php echo Html::a('Показать непроданные модели', ['index', 'id' => $category->id, $searchModel->formName() . '[flag]' => 1], ['class' => 'btn btn-success']); ?>
            <?php if (Yii::$app->user->identity->role == 'admin'): ?>
                <?= Html::a('Удалить выбранные', '#', ['class' => 'btn btn-danger', 'data-toggle' => 'modal', 'data-target' => '#delete-modal']) ?>
            <?php endif; ?>
            <?php if (Yii::$app->user->identity->role == 'admin'): ?>
                <?php if (empty($category->getChildren())): ?>
                    <?php echo Html::a('Импортировать из CSV', ['import', 'id' => $category->id], ['class' => 'btn btn-success']); ?>
                <?php endif; ?>
                <?php echo Html::a('Отменить импорт', '#', ['class' => 'btn btn-success', 'data-toggle' => 'modal', 'data-target' => '#backup-modal']); ?>
            <?php endif; ?>
            <?php echo Html::a('Показать модели без фото', ['index', 'id' => $category->id, $searchModel->formName() . '[nophotos]' => 1], ['class' => 'btn btn-success']); ?>
            <?php echo Html::a('Показать модели без цветов', ['index', 'id' => $category->id, $searchModel->formName() . '[nocolor]' => '1'], ['class' => 'btn btn-success']); ?>
            <?php echo Html::a('Показать модели без описания', ['index', 'id' => $category->id, $searchModel->formName() . '[nodescription]' => 1], ['class' => 'btn btn-success']); ?>
            <?php echo Html::a('Показать все модели', ['index', 'id' => $category->id], ['class' => 'btn btn-success']); ?>
        <?php else: ?>
            Каталог
        <?php endif; ?>
        <div class="form-group">
        </div>
        <?php echo GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                [
                    'class' => CheckboxColumn::className()
                ],
                [
                    'class' => ActionColumn::className(),
                    'template' => '{update} {delete}',
                    'buttons' => [
                        'delete' => function ($url, $model, $key) use ($category) {
                            return Html::a('<span class="glyphicon glyphicon-trash edit-icon-class"></span>',
                                ['delete', 'id' => $category->id, 'product_id' => $model->id],
                                ['data-type' => 'POST', 'data-confirm' => 'Удалить товар?']
                            );
                        },
                    ],
                    'visibleButtons' => [
                        'delete' => Yii::$app->user->identity->role == 'admin'
                    ]
                ],
                [
                    'label' => 'Изображение',
                    'value' => function ($model) {
                        return isset($model->pictures[0]) ? Html::img($model->pictures[0]->getUrl(), ['style' => 'display: block; margin: 0 auto; max-width: 110px; max-height: 85px;']) : '';
                    },
                    'format' => 'raw'
                ],
                'article',
                [
                    'attribute' => 'article_index',
                    'label' => 'Артикул /<br /> индекс',
                    'encodeLabel' => false
                ],
                'name',
                [
                    'label' => 'Кол-во <br />фото',
                    'value' => function ($model) {
                        return count($model->pictures);
                    },
                    'encodeLabel' => false
                ],
                [
                    'label' => 'Кол-во <br />цветов',
                    'value' => function ($model) {
                        if ($model->color != '') {
                            return count(explode(',', $model->color));
                        } else {
                            return 0;
                        }
                    },
                    'encodeLabel' => false
                ],
                [
                    'attribute' => 'price',
                    'value' => function ($model) {
                        return Yii::$app->formatter->asDecimal($model->price, 2);
                    },
                    'contentOptions' => ['class' => 'text-right']
                ],
                [
                    'attribute' => 'price2',
                    'value' => function ($model) {
                        return Yii::$app->formatter->asDecimal($model->price2, 2);
                    },
                    'contentOptions' => ['class' => 'text-right']
                ]
            ],
            'layout' => '{pager} {items} {pager}',
            'rowOptions' => function($model){
                if($model->flag == 0) {
                    return ['class' => 'product_sale'];
                }
            }
        ]); ?>
        <?= Html::endForm(); ?>
    </div>
</div>

<?php Modal::begin([
    'id' => 'delete-modal',
    'header' => 'Удалить выбраные'
]) ?>
<p>Вы действительно хотите удалить выбраные товары?</p>
<div class="form-group">
    <?php echo Html::a('Отмена', '#', ['class' => 'btn btn-default', 'data-dismiss' => 'modal']); ?>
    <?php echo Html::a('Удалить', '#', ['class' => 'btn btn-success', 'data-dismiss' => 'modal', 'data-toggle' => 'modal', 'data-target' => '#sendmail-modal']); ?>
</div>
<?php Modal::end(); ?>

<?php Modal::begin([
    'id' => 'sendmail-modal',
    'header' => 'Удалить выбраные'
]) ?>
<p>Подтвердите удаление?</p>
<div class="form-group">
    <?php echo Html::a('Отмена', '#', ['class' => 'btn btn-default', 'data-dismiss' => 'modal']); ?>
    <?php echo Html::a('Удалить', '#', ['class' => 'btn btn-success delete-btn']); ?>
</div>
<?php Modal::end(); ?>


<?php Modal::begin([
    'id' => 'delete-photo-modal',
    'header' => 'Удалить все фото'
]) ?>
<p>Вы действительно хотите удалить все фото?</p>
<div class="form-group">
    <?php echo Html::a('Отмена', '#', ['class' => 'btn btn-default', 'data-dismiss' => 'modal']); ?>
    <?php echo Html::a('Удалить', '#', ['class' => 'btn btn-success', 'data-dismiss' => 'modal', 'data-toggle' => 'modal', 'data-target' => '#confirm-modal']); ?>
</div>
<?php Modal::end(); ?>

<?php Modal::begin([
    'id' => 'confirm-modal',
    'header' => 'Удалить все фото'
]) ?>
<p>Подтвердите удаление?</p>
<div class="form-group">
    <?php echo Html::a('Отмена', '#', ['class' => 'btn btn-default', 'data-dismiss' => 'modal']); ?>
    <?php echo Html::a('Удалить', ['deletephotos', 'id' => $category->id], ['class' => 'btn btn-success']); ?>
</div>
<?php Modal::end(); ?>


<?php Modal::begin([
    'id' => 'backup-modal',
    'header' => 'Отменить последний импорт'
]) ?>
<p>Вы действительно хотите отменить последний импорт?</p>
<div class="form-group">
    <?php echo Html::a('Нет', '#', ['class' => 'btn btn-default', 'data-dismiss' => 'modal']); ?>
    <?php echo Html::a('Да', '#', ['class' => 'btn btn-success', 'data-dismiss' => 'modal', 'data-toggle' => 'modal', 'data-target' => '#confirm-backup-modal']); ?>
</div>
<?php Modal::end(); ?>

<?php Modal::begin([
    'id' => 'confirm-backup-modal',
    'header' => 'Отменить последний импорт'
]) ?>
<p>Подтвердите отмену последнего импорта?</p>
<div class="form-group">
    <?php echo Html::a('Отмена', '#', ['class' => 'btn btn-default', 'data-dismiss' => 'modal']); ?>
    <?php echo Html::a('Подтвердить', ['backup', 'id' => $category->id], ['class' => 'btn btn-success']); ?>
</div>
<?php Modal::end(); ?>
