<?php
/**
 * @var $model \app\models\Products
 */
use yii\helpers\Html;
?>
<?php echo Html::a(Html::img(isset($model->pictures[0])?$model->pictures[0]->getUrl():'/images/zag_240_320.jpg'), $model->slug) ?>
<div class="model">№<?php echo $model->article ?></div>
<?php if(!Yii::$app->user->isGuest && Yii::$app->user->identity->getIsActive()): ?>
    <div class="price"><strong>Цена</strong> за 1шт.:
        <strong><?php echo Yii::$app->formatter->asDecimal($model->price, 2) ?> ₽</strong>
    </div>
<?php endif; ?>
<div class="status <?php echo $model->flag?'':'off' ?> fl"><?php echo $model->flag?'Товар в наличии':'Товар продан' ?></div>
<?php echo Html::a('Подробнее', $model->slug, ['class' => 'view_product fr']); ?>
<div class="clear"></div>