<?php

/**
 * @var $model \app\models\Page
 * @var $this \yii\web\View
 */
?>
<div class="container">
    <?php echo $this->render('../_alert', ['module' => \Yii::$app->getModule('user')]); ?>
    <h2>Изменить новость</h2>
    <?php echo $this->render('_form', ['model' => $model]); ?>
</div>