<?php

use yii\bootstrap\Nav;
use app\models\Cart;
use app\models\User;

$count = User::find()->where('user.cart_sum >= 3000')->count();

$s = date("Y-m-d H:i:s", strtotime("-1 months"));
$f = date("Y-m-d H:i:s");

$users = User::find()
    ->select('user.*, (SELECT COUNT(*) FROM imports WHERE imports.user_id=user.id AND datetime BETWEEN \'' . $s . '\' AND \'' . $f . '\') as imports')
    ->where('(SELECT COUNT(*) FROM imports WHERE imports.user_id=user.id AND datetime BETWEEN \'' . $s . '\' AND \'' . $f . '\') > 0')
    ->orderBy(['imports' => SORT_DESC])->count();

?>
<div class="container">
    <?php echo Nav::widget([
        'items' => [
            [
                'label' => 'Структура',
                'url' => ['/'.MODULE_ID.'/pages'],
                'active' => Yii::$app->controller->id == 'pages',
                'visible' => in_array(Yii::$app->user->identity->role, ['admin'])
            ],
            [
                'label' => 'Каталог товаров',
                'url' => ['/'.MODULE_ID.'/catalog'],
                'active' => Yii::$app->controller->id == 'catalog',
                'visible' => in_array(Yii::$app->user->identity->role, ['admin', 'moderator', 'contentmanager'])
            ],
            [
                'label' => 'Новости',
                'url' => ['/'.MODULE_ID.'/news'],
                'active' => Yii::$app->controller->id == 'news',
                'visible' => in_array(Yii::$app->user->identity->role, ['admin', 'contentmanager'])
            ],
            [
                'label' => 'Пользователи',
                'url' => ['/user/'.MODULE_ID],
                'active' => Yii::$app->controller->id == 'admin',
                'visible' => in_array(Yii::$app->user->identity->role, ['admin', 'manager', 'contentmanager'])
            ],
            [
                'label' => 'Настройки',
                'url' => ['/'.MODULE_ID.'/settings'],
                'active' => Yii::$app->controller->id == 'settings',
                'visible' => in_array(Yii::$app->user->identity->role, ['admin'])
            ],
            //        [
            //            'label' => 'Редактировать меню',
            //            'url' => ['/'.MODULE_ID.'/menu'],
            //            'active' => Yii::$app->controller->id == 'menu',
            //            'visible' => in_array(Yii::$app->user->identity->role, ['admin'])
            //        ],
            [
                'label' => 'Заказы',
                'url' => ['/'.MODULE_ID.'/orders'],
                'active' => Yii::$app->controller->id == 'orders',
                'visible' => in_array(Yii::$app->user->identity->role, ['admin', 'manager', 'contentmanager'])
            ],
            [
                'label' => 'В корзине от 3000 (' . $count . ')',
                'url' => ['/'.MODULE_ID.'/bigcart'],
                'active' => Yii::$app->controller->id == 'bigcart',
                'visible' => in_array(Yii::$app->user->identity->role, ['admin', 'manager', 'contentmanager'])
            ],
            [
                'label' => 'Скачали каталог (' . $users . ')',
                'url' => ['/'.MODULE_ID.'/imports'],
                'active' => Yii::$app->controller->id == 'imports',
                'visible' => in_array(Yii::$app->user->identity->role, ['admin'])
            ],
            [
                'label' => 'Рассылка в мессенджеры',
                'url' => ['/'.MODULE_ID.'/send'],
                'active' => Yii::$app->controller->id == 'send',
                'visible' => in_array(Yii::$app->user->identity->role, ['admin', 'contentmanager'])
            ],
            [
                'label' => 'Очистить базу',
                'url' => ['/'.MODULE_ID.'/clear'],
                'active' => Yii::$app->controller->id == 'clear',
                'visible' => in_array(Yii::$app->user->identity->role, ['admin'])
            ],

        ],
        'options' => ['class' => 'navbar-nav navbar-default']
    ]); ?>
</div>