<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;
use app\models\Page;
$page = Page::findOne(['module' => 'error']);

Yii::$app->params['page'] = $page;

$this->title = Yii::$app->params['page']->title;
?>
<main>
    <div class="wrap category">
<div class="site-error">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php echo Yii::$app->params['page']->text; ?>
    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>
    <?php echo Yii::$app->params['page']->additional_text; ?>

</div>
</div>
<main>
