<?php
use yii\bootstrap\Nav;
?>
<div class="row">
<div class="col-md-12">

<?php echo Nav::widget([
    'items' => [
        ['label' => 'Основные', 'url' => ['/'.MODULE_ID.'/settings']],
        ['label' => 'Авторизация', 'url' => ['/'.MODULE_ID.'/settings/auth']],
        ['label' => 'Электронные письма', 'url' => ['/'.MODULE_ID.'/settings/emails']],
        ['label' => 'Настройки почты', 'url' => ['/'.MODULE_ID.'/settings/mail']],
        ['label' => 'Уведомления пользователю', 'url' => ['/'.MODULE_ID.'/settings/notify']],
    ],
    'options' => ['class' => 'navbar-nav navbar-default']
]); ?>
</div>
</div>
