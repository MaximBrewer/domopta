<?php
/**
 * @var $this \yii\web\View
 */
$page = \app\models\Page::find()->where(['slug' => '/order'])->one();
Yii::$app->params['page'] = $page;
?>
<div class="container">
    <div class="order_success1">
        <?php echo $page->text;?>
    </div>
</div>
