<?php
use yii\bootstrap\Nav;
?>
<div class="row">
<div class="col-md-12">

<?php echo Nav::widget([
    'items' => [
        // ['label' => 'Основные', 'url' => ['/adminka/settings']],
        ['label' => 'Контакты', 'url' => ['/adminka/settings/auth']],
        ['label' => 'Электронные письма', 'url' => ['/adminka/settings/emails']],
        ['label' => 'Настройки почты', 'url' => ['/adminka/settings/mail']],
        ['label' => 'Уведомления пользователю', 'url' => ['/adminka/settings/notify']],
        ['label' => 'Подсказки для ценовых категорий', 'url' => ['/adminka/settings/hint']],
    ],
    'options' => ['class' => 'navbar-nav navbar-default']
]); ?>
</div>
</div>
