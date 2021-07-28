<?php
/**
 * @var $this \yii\web\View
 * @var $order \app\models\Order
 */
echo $this->render('_email', ['order' => $order]);
?>
<script>
    window.print();
</script>