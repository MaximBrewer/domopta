<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;
use app\components\Breadcrumbs;
use app\models\Page;

$page = Page::findOne(['module' => 'error']);

Yii::$app->params['page'] = $page;

$this->title = Yii::$app->params['page']->title;
?>
<main id="cat_page">
    <div class="wrap inner_product pr">
        <div class="breadcrumb main__breadcrumb">
            <div class="container">
                <?= Breadcrumbs::widget([
                    'links' => [[
                        'label' => Yii::$app->params['page']->title,
                        'url' => '',
                        'template' => Yii::$app->params['page']->title, // template for this link only
                    ]],
                    'homeLink' => [
                        'label' => 'Главная',
                        'url' => '/'
                    ],
                    'tag' => 'div',
                    'options' => ['class' => 'bread'],
                    'itemTemplate' => '{link}',
                    'activeItemTemplate' => '{link}',
                    'glue' => ' > '

                ]) ?>
            </div>
        </div>
        <div class="container container_fl-wr">
            <div class="content-right">
                <div class="novost">
                    <div class="novost-top">
                        <div class="content__title"><?php echo Yii::$app->params['page']->name ?></div>
                        <div class="novost__text">
                            <div class="stat_text">
                                <?php echo Yii::$app->params['page']->text ?>
                                <?php echo Yii::$app->params['page']->additional_text ?>
                            </div>
                        </div>
                    </div>
                    <div class="novost-middle">
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>