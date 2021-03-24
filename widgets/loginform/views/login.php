<?php
/**
 * @var $form ActiveForm;
 * @var $model \app\models\LoginForm
 */
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>
<?php if(Yii::$app->user->isGuest): ?>
    <?php $form = ActiveForm::begin(['action' => ['/site/index'], 'id' => 'login_form']); ?>
    <?php echo Html::activeTextInput($model, 'login', ['placeholder' => 'Email', 'class' => 'fl']) ?>
    <?php echo Html::activePasswordInput($model, 'password', ['placeholder' => '*****', 'class' => 'fl']) ?>
    <div class="clear"></div>
    <?php echo Html::a('Регистрация', ['/user/registration/register'], ['class' => 'but fl mr10']) ?>
    <?php echo Html::submitInput('Войти', ['class' => 'but fl']) ?>
    <div class="clear"></div>

    <?php echo Html::a('Забыли пароль?', ['/user/recovery/request'], ['class' => 'text']) ?>
    <?php ActiveForm::end(); ?>
<?php else: ?>
    <div class="user-info">
        <div class="fl"><img src="/images/user.png" /></div>
            <div class="hello fl">
                <?php echo Yii::$app->user->identity->profile->name ?>
                <br />
                <?php echo Yii::$app->user->identity->profile->lastname ?>
            </div>
            <div class="fr">
                <?php echo Html::a('Выйти', ['/user/security/logout'], ['class' => 'logout', 'data-method' => 'POST']) ?>
            </div>
            <div class="clear"></div>

    </div>
<?php endif; ?>
