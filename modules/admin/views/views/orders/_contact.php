<?php
/**
 * @var $this \yii\web\View
 * @var $order \app\models\Order
 */
use yii\widgets\DetailView;
?>
<?php Echo DetailView::widget([
    'model' => $order,
    'attributes' => [
        'user.profile.lastname',
        'user.profile.name',
        'user.profile.surname',
        'user.profile.city',
        'user.profile.region',
        'user.profile.organization_name',
        'user.profile.phone',
        'user.email',
        'user.profile.inn',
    ]
]) ?>
