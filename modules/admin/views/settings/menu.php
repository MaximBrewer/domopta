<?php
use yii\bootstrap\Nav;
?>
<div class="container">

<?php echo Nav::widget([
    'items' => [
        // ['label' => 'Основные', 'url' => ['/'.MODULE_ID.'/settings']],
        ['label' => 'Контакты', 'url' => ['/'.MODULE_ID.'/settings/auth']],
        ['label' => 'Электронные письма', 'url' => ['/'.MODULE_ID.'/settings/emails']],
        ['label' => 'Настройки почты', 'url' => ['/'.MODULE_ID.'/settings/mail']],
        ['label' => 'Уведомления пользователю', 'url' => ['/'.MODULE_ID.'/settings/notify']],
        ['label' => 'Подсказки для ценовых категорий', 'url' => ['/'.MODULE_ID.'/settings/hint']],
    ],
    'options' => ['class' => 'navbar-nav navbar-default']
]); ?>
</div>
