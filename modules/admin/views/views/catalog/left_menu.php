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
?>
<?php if(Yii::$app->user->identity->role == 'admin'): ?>
    <?php echo Html::a('Создать', ['/'.MODULE_ID.'/catalog/addcategory', 'id' => $category->id], ['class' => 'btn btn-success']); ?>
    <?php echo Html::a('Удалить', '#', ['class' => 'btn btn-danger', 'data-toggle' => 'modal', 'data-target' => '#delete-cat-modal']); ?>
<?php endif; ?>
<p class="total-products">Всего товаров: <?php echo Products::find()->where(['<>', 'is_deleted', 1])->count();  ?></p>
<?php $form = ActiveForm::begin(['method' => 'get']) ?>
<?php echo Html::label('Поиск') ?><br />
<?php echo Html::textInput($searchModel->formName() . '[text]', $searchModel->text, ['class' => 'form-control']) ?>
<?php echo Html::radioList($searchModel->formName() . '[text_type]', $searchModel->text_type?$searchModel->text_type:0,['Текущая категория', 'Каталог']) ?>
<?php echo Html::submitInput('Искать', ['class' => 'btn btn-success']) ?>
<?php ActiveForm::end(); ?>
<?php
$items = [];
foreach ($category_list as $k => $cat){
    $items[$k] = [
        'text' => $cat->name . ' (' . $cat->getProductCount() . ')',
        'href' => Url::to(['index', 'id' => $cat->id]),
        'searchResult' => $cat->id == $category->id
    ];
    foreach ($cat->getChildren() as $cat2){
        $items[$k]['nodes'][] = [
            'text' => $cat2->name . ' (' . $cat2->getProductCount() . ')',
            'href' => Url::to(['index', 'id' => $cat2->id]),
            'searchResult' => $cat2->id == $category->id
        ];
    }
}
echo TreeView::widget([
    'data' => $items,
    'size' => TreeView::SIZE_SMALL,
    'template' => TreeView::TEMPLATE_SIMPLE,
    'clientOptions' => [
        'enableLinks' => true,
//                'onNodeSelected' => 'function (undefined, item) {alert(1);}',
    ],
]);

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
        <?php echo Html::a('Удалить', ['/'.MODULE_ID.'/catalog/deletecategory', 'id' => $category->id], ['class' => 'btn btn-success']); ?>
        <?php echo Html::a('Отмена', '#',['class' => 'btn btn-default', 'data-dismiss' => 'modal']); ?>
    </div>
<?php Modal::end(); ?>