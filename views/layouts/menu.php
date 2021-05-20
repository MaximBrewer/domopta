<?php
use yii\bootstrap\Nav;
use app\models\Cart;

$allcarts = Cart::find()->all();
$users = [];
foreach ($allcarts as $cart){
	if(!isset($users[$cart->user_id])){
		$users[$cart->user_id] = 0;
	}
	$users[$cart->user_id] += $cart->getSum();
}
$count = 0;
foreach ($users as $id => $sum){
    $user = \app\models\User::findOne($id);
	if($user && $sum >= 5000){
		$count++;
	}
}

?>
<div class="container">
<?php echo Nav::widget([
    'items' => [
        [
            'label' => 'Структура',
            'url' => ['/adminka/pages'],
            'active' => Yii::$app->controller->id == 'pages',
            'visible' => in_array(Yii::$app->user->identity->role, ['admin'])
        ],
        [
            'label' => 'Каталог товаров',
            'url' => ['/adminka/catalog'],
            'active' => Yii::$app->controller->id == 'catalog',
            'visible' => in_array(Yii::$app->user->identity->role, ['admin', 'moderator', 'contentmanager'])
        ],
        [
            'label' => 'Новости',
            'url' => ['/adminka/news'],
            'active' => Yii::$app->controller->id == 'news',
            'visible' => in_array(Yii::$app->user->identity->role, ['admin', 'contentmanager'])
        ],
        [
            'label' => 'Пользователи',
            'url' => ['/user/admin'],
            'active' => Yii::$app->controller->id == 'admin',
            'visible' => in_array(Yii::$app->user->identity->role, ['admin', 'manager', 'contentmanager'])
        ],
        [
            'label' => 'Настройки',
            'url' => ['/adminka/settings'],
            'active' => Yii::$app->controller->id == 'settings',
            'visible' => in_array(Yii::$app->user->identity->role, ['admin'])
        ],
//        [
//            'label' => 'Редактировать меню',
//            'url' => ['/adminka/menu'],
//            'active' => Yii::$app->controller->id == 'menu',
//            'visible' => in_array(Yii::$app->user->identity->role, ['admin'])
//        ],
        [
            'label' => 'Заказы',
            'url' => ['/adminka/orders'],
            'active' => Yii::$app->controller->id == 'orders',
            'visible' => in_array(Yii::$app->user->identity->role, ['admin', 'manager', 'contentmanager'])
        ],
	    [
		    'label' => 'В корзине от 5000 (' . $count . ')',
		    'url' => ['/adminka/bigcart'],
		    'active' => Yii::$app->controller->id == 'bigcart',
		    'visible' => in_array(Yii::$app->user->identity->role, ['admin', 'manager', 'contentmanager'])
	    ],
	    [
		    'label' => 'Скачивания',
		    'url' => ['/adminka/imports'],
		    'active' => Yii::$app->controller->id == 'imports',
		    'visible' => in_array(Yii::$app->user->identity->role, ['admin', 'manager', 'contentmanager'])
	    ],
	    [
		    'label' => 'Рассылка в мессенджеры',
		    'url' => ['/adminka/send'],
		    'active' => Yii::$app->controller->id == 'send',
		    'visible' => in_array(Yii::$app->user->identity->role, ['admin', 'contentmanager'])
	    ],
        [
            'label' => 'Очистить базу',
            'url' => ['/adminka/clear'],
            'active' => Yii::$app->controller->id == 'clear',
            'visible' => in_array(Yii::$app->user->identity->role, ['admin'])
        ],

    ],
    'options' => ['class' => 'navbar-nav navbar-default']
]); ?>
</div>
