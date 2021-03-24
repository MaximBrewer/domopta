<?php
use yii\helpers\Html;
use yii\bootstrap\Alert;
?>
<div class="row">
    <div class="col-xs-12">
        <?php foreach (Yii::$app->session->getAllFlashes() as $type => $message): ?>
            <?php if (in_array($type, ['success', 'success1', 'success2', 'info'])): ?>
                <?= Alert::widget([
                    'options' => ['class' => 'alert-dismissible alert-success'],
                    'body' => is_array($message)?$message[0]:$message
                ]) ?>
            <?php endif ?>
        <?php endforeach ?>
    </div>
</div>
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