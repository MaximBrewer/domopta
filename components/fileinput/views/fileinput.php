<?php
/** @var $this \yii\web\View */

use yii\bootstrap\Html;
use yii\helpers\Url;

/** @var $input string */
\app\components\fileinput\FileInputAssets::register($this);
$this->registerJsVar("fl_model_id", $model->id);

$items = [];
$config = [];
foreach ($model->pictures as $image):
    $items[$image->id] = Html::img($image->getUrl('big', $image->order));
endforeach; ?>

<div class="fi">
    <div class="fl-top text-right" >
        <a href="#" class="btn btn-success fl-add-photo">Добавить фото</a>
        <a href="#" class="btn btn-danger fl-clear-photo">Очистить загруженные</a>
        <a href="#" class="btn btn-primary fl-upload">Загрузить</a>
    </div>
    <div class="progress fl-progress">
        <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
    </div>
    <div class="fl-content">
        <div class="fl-dd">
            <?php
            foreach ($items as $key => $item): ?>
                <div class="fl-item fl-item-uploaded" data-id="<?php echo $key ?>">
                    <?php echo $item; ?>
                    <div class="fl-btns">
                        <span class="fl-remove" title="Удалить"><i class="glyphicon glyphicon-trash"></i></span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php echo $input; ?>

    </div>
    <div class="fl-item-default">
        <img src="#">
        <div class="fl-btns">
            <span class="fl-remove" title="Удалить"><i class="glyphicon glyphicon-trash"></i></span>
        </div>
    </div>
    <div class="fl-upload-files"></div>
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Подробное превью</h4>
            </div>
            <div class="modal-body">
                <img src="#" id="modal_image">
            </div>
        </div>
    </div>
</div>
