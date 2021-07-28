<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Nav;
use kartik\icons\Icon;
use app\models\User;

Icon::map($this, Icon::FA);

/**
 * @var \yii\web\View $this
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var \dektrium\user\models\UserSearch $searchModel
 * @var \app\models\BlockForm $blockForm
 * @var ActiveForm $form
 */

$this->registerJsFile('/js/users.js', ['depends' => \app\assets\AppAsset::className()]);

$this->title = Yii::t('user', 'Manage users');
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('../../_alert', ['module' => Yii::$app->getModule('user')]) ?>

<div class="row">
    <?php if (in_array(Yii::$app->user->identity->role, ['admin'])) : ?>
        <div class="col-md-2">
            <?php echo Nav::widget([
                'items' => [
                    ['label' => 'Демо', 'url' => ['/user/admin', $searchModel->formName() . '[demo]' => 1]],
                    ['label' => 'Подозрительный тип', 'url' => ['/user/admin', $searchModel->formName() . '[suspicious]' => 1]],
                    ['label' => 'Активные', 'url' => ['/user/admin', $searchModel->formName() . '[is_active]' => 1]],
                    ['label' => 'Заблокированные', 'url' => ['/user/admin', $searchModel->formName() . '[blocked_at]' => 1]],
                    ['label' => 'Игнорированные', 'url' => ['/user/admin', $searchModel->formName() . '[is_ignored]' => 1]],
                    //['label' => 'Не подтвердили свой Email', 'url' => ['/user/admin', $searchModel->formName() . '[not_confirmed]' => 1]],
                    ['label' => 'Не активированные', 'url' => ['/user/admin', $searchModel->formName() . '[not_active]' => 1]],
                ]
            ]) ?>
        </div>
        <div class="col-md-10">
        <? else : ?>
        <div class="col-md-12">
        <? endif; ?>
        <?= Html::beginForm(['/user/admin/deletemultiply'], 'post', ['id' => 'deletemultiply-form']) ?>
        <?php if (Yii::$app->user->identity->role == 'admin') : ?>
            <div class="form-group">
                <?= Html::a('Удалить выбранных', '#', ['class' => 'btn btn-danger', 'data-toggle' => 'modal', 'data-target' => '#delete-modal']) ?>
                <?= Html::hiddenInput('sendemail'); ?>
            </div>
        <?php endif; ?>
        <p>Активированных (<?php echo User::countActivated() ?>), Заблокировано (<?php echo User::countBlocked() ?>), Игнорировано (<?php echo User::countIgnored() ?>), Всего (<?php echo User::find()->count() ?>)</p>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel'  => $searchModel,
            'layout'       => "{pager}\n{items}\n{pager}",
            'columns' => [
                [
                    'class' => \yii\grid\CheckboxColumn::className(),
                    'checkboxOptions' => function ($model) {
                        if ($model->not_delete == 1)
                            return ['disabled' => 'disabled'];
                    },
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'header' => 'Действия',
                    'template' => '<div style="display:flex;">{update} {activate} {block} {unblock} {info} {ignore} {unignore} {delete}</div>',
                    'visibleButtons' => [
                        'update' => Yii::$app->user->identity->role == 'admin',
                        'activate' => Yii::$app->user->identity->role == 'admin',
                        'block' => Yii::$app->user->identity->role == 'admin',
                        'unblock' => Yii::$app->user->identity->role == 'admin',
                        'delete' => function ($model) {
                            return $model->not_delete != 1 && Yii::$app->user->identity->role == 'admin';
                        },
                        'ignore' => Yii::$app->user->identity->role == 'admin',
                        'unignore' => Yii::$app->user->identity->role == 'admin',
                    ],
                    'buttons' => [
                        'activate' => function ($url, $model, $key) {
                            if ($model->confirmed_at && $model->is_active == 0) {
                                return '
                    <a  href="' . Url::to(['/user/adminka/activate', 'id' => $model->id]) . '" style="margin-right:.3rem;">
                    <span title="Активировать пользователя" class="glyphicon glyphicon-ok">
                    </span> </a>';
                            }
                        },
                        'block' => function ($url, $model) {
                            if (!$model->blocked_at) {
                                return '
                            <a style="margin-right:.3rem;" data-id="' . $model->id . '" data-toggle="modal" data-target="#block-modal" class="block_link" href="' . Url::to(['/user/adminka/block', 'id' => $model->id]) . '">
                            <span title="Блокировать пользователя" class="fa fa-lock"></span>
</a>
                        ';
                            }
                        },
                        'update' => function ($url, $model) {
                            return Html::a('<span class="fa fa-edit"></span>', $url, ['data-pjax' => '0', 'style' => "margin-right:.3rem;", 'aria-label' => 'Редактировать', 'title' => 'Редактировать']);
                        },
                        'info' => function ($url, $model) {
                            if ($model->blocked_at) {
                                return '
                            <a style="margin-right:.3rem;" data-id="' . $model->id . '" data-toggle="modal" data-target="#info-modal" class="info_link" data-text="' . $model->profile->admins_comment . '">
                            <span title="Причина блокировки" class="glyphicon glyphicon-info-sign"></span>
</a>
                        ';
                            }
                        },
                        'unblock' => function ($url, $model) {
                            if ($model->blocked_at) {
                                return '
                            <a style="margin-right:.3rem;" data-method="POST" href="' . Url::to(['/user/adminka/block', 'id' => $model->id]) . '">
                            <span title="Разблокировать пользователя" class="fa fa-unlock"></span>
</a>
                        ';
                            }
                        },
                        'ignore' => function ($url, $model) {
                            if (!$model->is_ignored) {
                                return '
                            <a style="margin-right:.3rem;" data-method="POST" href="' . Url::to(['/user/adminka/ignore', 'id' => $model->id]) . '">
                            <span title="Игнорировать пользователя" class="glyphicon glyphicon-minus"></span>
</a>
                        ';
                            }
                        },
                        'unignore' => function ($url, $model) {
                            if ($model->is_ignored) {
                                return '
                            <a style="margin-right:.3rem;" data-method="POST" href="' . Url::to(['/user/adminka/ignore', 'id' => $model->id]) . '">
                            <span title="Не игнорировать пользователя" class="glyphicon glyphicon-plus"></span>
</a>
                        ';
                            }
                        },
                        'delete' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-trash" title="Удалить"></span>', $url, ['class' => 'delete-user', 'data-id' => $model->id]);
                        }
                    ],
                ],
                /*        [
	        'attribute' => 'role',
            'value' => function($model){
                if ($model->role == 'moderator'){
                    return 'photograph';
                }
                return $model->role;
            }
        ],*/
                [
                    'attribute' => 'name',
                    'label' => 'Фамилия / Имя',
                    'value' => function ($model, $key, $index, $column) {
                        if ($model->profile->lastname || $model->profile->name)
                            return $model->profile->lastname . '<br />' . $model->profile->name;
                        return '';
                    },
                    'format' => 'raw'
                ],
                [
                    'attribute' => 'organization',
                    'value' => function ($model, $key, $index, $column) {
                        if ($model->profile->organization_name)
                            return $model->profile->organization_name;
                        return '';
                    }
                ],
                [
                    'attribute' => 'location',
                    'label' => 'Город / Область',
                    'value' => function ($model, $key, $index, $column) {
                        if ($model->profile->city || $model->profile->region)
                            return $model->profile->city . '<br />' . $model->profile->region;
                        return '';
                    },
                    'format' => 'raw'
                ],
                [
                    'attribute' => 'phone',
                    'value' => function ($model, $key, $index, $column) {
                        if ($model->username)
                            return $model->username;
                        return '';
                    }
                ],
                [
                    'label' => 'Тип цены',
                    'value' => function ($model) {
                        if ($model->profile->type == 2) {
                            return 'Мелкий опт';
                        }
                        return 'Опт';
                    }
                ],
                'email',
                [
                    'attribute' => 'inn',
                    'value' => function ($model) {
                        if ($model->profile->inn)
                            return $model->profile->inn;
                        return '';
                    }
                ],
                [
                    'attribute' => 'created_at',
                    'value' => function ($model) {
                        if ($model->created_at)
                            return Yii::$app->formatter->asDate($model->created_at, 'php:d.m.Y');
                        return '';
                    }
                ]
                //        'created_at:date',
            ],
            'rowOptions' => function ($model, $key, $index, $grid) {
                if (!$model->confirmed_at) {
                    return ['class' => 'noactive'];
                }
                if ($model->getIsBlocked()) {
                    return ['class' => 'blocked'];
                }
                if ($model->getIsIgnored()) {
                    return ['class' => 'ignored'];
                }
                if ($model->is_active) {
                    return ['class' => 'activated'];
                }
            },
            'tableOptions' => ['class' => 'table table-bordered']
        ]); ?>
        <?= Html::endForm(); ?>
        </div>
</div>

<?php Modal::begin([
    'id' => 'block-modal',
    'header' => 'Блокировать пользователя'
]) ?>
<?php $form = ActiveForm::begin(['method' => 'post', 'action' => Url::to(['/user/adminka/block']), 'id' => 'block-form']); ?>
<?php echo $form->field($blockForm, 'id')->label(false)->hiddenInput(); ?>
<?php echo $form->field($blockForm, 'text')->textarea(); ?>
<div class="form-group">
    <?php echo Html::submitButton('Блокировать', ['class' => 'btn btn-success']); ?>
</div>
<?php ActiveForm::end(); ?>
<?php Modal::end(); ?>

<?php Modal::begin([
    'id' => 'info-modal',
    'header' => 'Причина блокировки'
]) ?>

<?php Modal::end(); ?>


<?php Modal::begin([
    'id' => 'delete-modal',
    'header' => 'Удалить выбранных'
]) ?>
<p>Вы действительно хотите удалить выбранных пользователей?</p>
<div class="form-group">
    <?php echo Html::a('Удалить', '#', ['class' => 'btn btn-success delete-btn', 'data-send' => 0]); ?>
    <?php echo Html::a('Отмена', '#', ['class' => 'btn btn-default', 'data-dismiss' => 'modal']); ?>
</div>
<?php Modal::end(); ?>

<?php Modal::begin([
    'id' => 'delete-one-modal1',
    'header' => 'Удалить пользывателя'
]) ?>
<p>Вы действительно хотите удалить пользователя?</p>
<div class="form-group">
    <?php echo Html::a('Удалить', '#', ['class' => 'btn btn-success', 'data-dismiss' => 'modal', 'data-toggle' => 'modal', 'data-target' => '#sendmail-one-modal']); ?>
    <?php echo Html::a('Отмена', '#', ['class' => 'btn btn-default', 'data-dismiss' => 'modal']); ?>
</div>
<?php Modal::end(); ?>

<?php
Modal::begin([
    'id' => 'delete-one-modal',
    'header' => 'Удалить пользывателя'
])
?>
<p>действительно хотите удалить пользователя?</p>
<?php echo Html::beginForm(['delete'], 'post', ['id' => 'delete-user']) ?>
<?php echo Html::hiddenInput('id', '', ['id' => 'delete-user-id']) ?>
<?php echo Html::hiddenInput('send', '', ['id' => 'delete-user-send']) ?>
<?php Html::endForm() ?>
<div class="form-group">
    <?php echo Html::a('Да', '#', ['class' => 'btn btn-success delete-one-btn', 'data-send' => 0]); ?>
    <?php echo Html::a('Отмена', '#', ['class' => 'btn btn-default', 'data-dismiss' => 'modal']); ?>
</div>
<?php Modal::end(); ?>