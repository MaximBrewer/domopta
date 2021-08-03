<?php

use yii\helpers\Html;
use yii\bootstrap\Alert;
?>
<div class="container">
    <?php echo $this->render('../_alert', ['module' => \Yii::$app->getModule('user')]); ?>
    <div class="form-group">
        <?php echo Html::beginForm('') ?>
        <?php echo Html::hiddenInput('products', '1') ?>
        <?php echo Html::submitInput('Очистить удаленные товары старше 6 месяцев', ['class' => 'btn btn-danger']) ?>
        <?php echo  Html::endForm(); ?>
    </div>
    <div class="form-group">
        <?php echo Html::beginForm('') ?>
        <?php echo Html::hiddenInput('orders', '1') ?>
        <?php echo Html::submitInput('Очистить заказы старше 6 месяцев', ['class' => 'btn btn-danger']) ?>
        <?php echo  Html::endForm(); ?>
    </div>
</div>