<?php
/**
 * Created by PhpStorm.
 * User: resh
 * Date: 23.05.17
 * Time: 16:13
 */
use yii\helpers\Html;
use execut\widget\TreeView;
use yii\helpers\Url;
use app\models\Products;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;
$this->registerJsFile('/js/tree.js', ['depends' => \app\assets\AdminAsset::className()]);
?>
<?php if(Yii::$app->user->identity->role == 'admin'): ?>
    <?php echo Html::a('Создать', ['/adminka/catalog/addcategory', 'id' => $category->id], ['class' => 'btn btn-success']); ?>
    <?php echo Html::a('Удалить', '#', ['class' => 'btn btn-danger', 'data-toggle' => 'modal', 'data-target' => '#delete-cat-modal']); ?>
<?php endif; ?>
<p class="total-products">Всего товаров: <?php echo Products::find()->where(['<>', 'is_deleted', 1])->count();  ?></p>
<?php $form = ActiveForm::begin(['method' => 'get']) ?>
<?php echo Html::label('Поиск') ?><br />
<?php echo Html::textInput($searchModel->formName() . '[text]', $searchModel->text, ['class' => 'form-control']) ?>
<?php echo Html::radioList($searchModel->formName() . '[text_type]', $searchModel->text_type?$searchModel->text_type:1,[1 => 'Каталог', 0 => 'Текущая категория']) ?>
<?php echo Html::submitInput('Искать', ['class' => 'btn btn-success search-class']) ?>
<?php ActiveForm::end(); ?>
<?php if(Yii::$app->user->identity->role == 'admin'): ?>
    <?php echo Html::checkbox('edit_tree', false, ['id' => 'edit_tree']); ?> Редактировать структуру
<?php endif; ?>
<div id="category_tree">
    <ul class="cat_lv_1">
    <?php foreach ($category_list as $k => $cat): ?>
    <li data-id="<?php echo $cat->id ?>" <?php echo Yii::$app->request->get('id') == $cat->id?'class="admin-bg_active"':'' ?> >
        <a href="<?php echo Url::to(['index', 'id' => $cat->id]) ?>"><?php echo Html::a($cat->name . ' (' . $cat->getProductCount() . ')', Url::to(['index', 'id' => $cat->id])) ?></a>
        <?php if($children = $cat->getChildren()): ?>
            <ul class="cat_lv_2">
            <?php foreach ($children as $cat2): ?>
                <li data-id="<?php echo $cat2->id ?>" <?php echo Yii::$app->request->get('id') == $cat2->id?'class="admin-bg_active"':'' ?> >
                <a href="<?php echo Url::to(['index', 'id' => $cat2->id]) ?>"><?php echo Html::a($cat2->name . ' (' . $cat2->getProductCount() . ')', Url::to(['index', 'id' => $cat2->id])) ?></a>
            </li>
            <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </li>
    <?php endforeach; ?>
    </ul>
</div>
<?php

$items = [];
foreach ($category_list as $k => $cat){
    $items[$k] = [
        'text' => Html::a($cat->name . ' (' . $cat->getProductCount() . ')', Url::to(['index', 'id' => $cat->id])),
        'href' => Url::to(['index', 'id' => $cat->id]),
        'searchResult' => $cat->id == $category->id
    ];
    foreach ($cat->getChildren() as $cat2){
        $items[$k]['nodes'][] = [
            'text' => Html::a($cat2->name . ' (' . $cat2->getProductCount() . ')', Url::to(['index', 'id' => $cat2->id])),
            'href' => Url::to(['index', 'id' => $cat2->id]),
            'searchResult' => $cat2->id == $category->id
        ];
    }
}
//echo TreeView::widget([
//    'data' => $items,
//    'size' => TreeView::SIZE_SMALL,
//    'template' => TreeView::TEMPLATE_SIMPLE,
//    'clientOptions' => [
//        'enableLinks' => true,
////                'onNodeSelected' => 'function (undefined, item) {alert(1);}',
//    ],
//]);

?>

<?php Modal::begin([
    'id' => 'delete-cat-modal',
    'header' => 'Удалить категорию'
]) ?>
    <p>Вы действительно хотите удалить категорию "<?php echo $category->name?>" и все товары в ней?</p>
    <div class="form-group">
        <?php echo Html::a('Удалить', '#', ['class' => 'btn btn-success', 'data-dismiss' => 'modal', 'data-toggle' => 'modal', 'data-target' => '#confirm-cat-modal']); ?>
        <?php echo Html::a('Отмена', '#',['class' => 'btn btn-default', 'data-dismiss' => 'modal']); ?>
    </div>
<?php Modal::end(); ?>

<?php Modal::begin([
    'id' => 'confirm-cat-modal',
    'header' => 'Удалить все фото'
]) ?>
    <p>Подтвердите удаление?</p>
    <div class="form-group">
        <?php echo Html::a('Удалить', ['/adminka/catalog/deletecategory', 'id' => $category->id], ['class' => 'btn btn-success']); ?>
        <?php echo Html::a('Отмена', '#',['class' => 'btn btn-default', 'data-dismiss' => 'modal']); ?>
    </div>
<?php Modal::end(); ?>