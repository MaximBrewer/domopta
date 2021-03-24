<?php
/**
 * @var $this \yii\web\View
 */

use app\components\Breadcrumbs;

$this->params['breadcrumbs'][] = ['label' => Yii::$app->params['page']->name, 'url' => Yii::$app->params['page']->slug];
?>
<main id="cat">
    <div class="wrap inner_product pr">
        <div class="breadcrumb main__breadcrumb">
            <div class="container">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
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
