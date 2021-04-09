<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

use yii\bootstrap\Nav;
/**
 * @var \yii\web\View $this
 * @var \dektrium\user\models\User $user
 * @var string $content
 */

$this->title = Yii::t('user', 'Update user account');
$this->params['breadcrumbs'][] = ['label' => Yii::t('user', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('/_alert', ['module' => Yii::$app->getModule('user')]) ?>

<div class="row">
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
        <div class="panel panel-default">
            <div class="panel-body">
            <?php $form = ActiveForm::begin([
                    'enableClientValidation' => false
            ]); ?>
            <?= $form->field($user->profile, 'type')->radioList(['1' => 'ИП (Опт)', '3' => 'ООО (Опт)', '2' => 'ФизЛицо (Мел/Опт)'], ['disabled' => Yii::$app->user->identity->role != 'admin']) ?>
            <?= $form->field($user->profile, 'demo')->checkbox(['disabled' => Yii::$app->user->identity->role != 'admin']) ?>
            <?= $form->field($user->profile, 'suspicious')->checkbox(['disabled' => Yii::$app->user->identity->role != 'admin']) ?>
            <?= $form->field($user, 'flags')->checkbox(['disabled' => Yii::$app->user->identity->role != 'admin'])->label('Товары только по ООО') ?>
            <?= $form->field($user->profile, 'lastname')->textInput() ?>
            <?= $form->field($user->profile, 'name')->textInput() ?>
            <?= $form->field($user->profile, 'surname')->textInput() ?>
            <?= $form->field($user->profile, 'city')->textInput() ?>
            <?= $form->field($user->profile, 'region')->textInput() ?>
            <?= $form->field($user->profile, 'organization_name')->textInput() ?>
            <?= $form->field($user, 'email')->textInput() ?>
            <?= $form->field($user->profile, 'inn')->textInput(['readonly' => Yii::$app->user->identity->role != 'admin']) ?>
            <?= $form->field($user->profile, 'users_comment')->textInput() ?>
            <?= $form->field($user->profile, 'admins_comment')->textInput(['readonly' => Yii::$app->user->identity->role != 'admin']) ?>
            <?= $form->field($user->profile, 'order_comment')->textInput() ?>
                <hr />
            <?= $form->field($user, 'role')->dropDownList(['admin' => 'Администратор', 'moderator' => 'Фотограф', 'manager' => 'Менеджер', 'contentmanager' => 'Контент-менеджер', 'user' => 'Пользователь'], ['disabled' => Yii::$app->user->identity->role != 'admin']) ?>
            <?= $form->field($user, 'username')->textInput(['readonly' => Yii::$app->user->identity->role != 'admin']) ?>
            <?= $form->field($user, 'not_delete')->checkbox(['disabled' => Yii::$app->user->identity->role != 'admin']) ?>
            <?= $form->field($user, 'is_active')->checkbox(['disabled' => Yii::$app->user->identity->role != 'admin']) ?>
            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']); ?>
            </div>
            <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
