<?php
/**
 * @var $model \app\models\News
 */
use yii\helpers\Html;
?>

    <div class="news__item-top">
        <img src="<?php echo $model->getThumbUploadUrl('image')?>" alt="domopta.ru - <?php echo str_replace('"', '', $model->name); ?>" class="news__img">
    </div>
    <div class="news__item-bottom">
        <div class="news__heading"><?php echo $model->name ?></div>
        <a href="<?php echo $model->slug ?>" class="news__link">читать полностью</a>
    </div>

