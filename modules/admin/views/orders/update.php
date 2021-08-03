<?php

/**
 * @var $this \yii\web\View
 * @var $order \app\models\Order
 */

use yii\bootstrap\Tabs;
?>
<div class="container">
    <?php echo $this->render('../_alert', ['module' => \Yii::$app->getModule('user')]); ?>
    <h2>Просмотр заказа</h2>
    <?php echo Tabs::widget([
        'items' => [
            [
                'label' => 'Основные данные',
                'content' => $this->render('_main', ['order' => $order])
            ],
            [
                'label' => 'Контактные данные',
                'content' => $this->render('_contact', ['order' => $order])
            ]
        ]
    ]); ?>
</div>