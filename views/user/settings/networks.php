<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use dektrium\user\widgets\Connect;
use yii\helpers\Html;
use app\models\Page;

/**
 * @var $this yii\web\View
 * @var $form yii\widgets\ActiveForm
 */
$page = Page::findOne(['id' => 35]);


$this->title = $page->name;
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="content content_flip main__content">
	<div class="container container_fl-wr">
		<div class="content-left">
			<?php echo $page->text;?>
			<?php /*
			<div class="row">
				<div class="col-md-9">
					<div class="panel panel-default">
						<div class="panel-body">
							<div class="alert alert-info">
								<p></p>
							</div>
							<br>
							<br>
							<?php $auth = Connect::begin([
								'baseAuthUrl' => ['/user/security/auth'],
								'accounts' => $user->accounts,
								'autoRender' => false,
								'popupMode' => false,
							]) ?>
							<table class="table">
								<?php foreach ($auth->getClients() as $client) : ?>
									<tr>
										<td style="width: 32px; vertical-align: middle">
											<?= Html::tag('span', '', ['class' => 'auth-icon ' . $client->getName()]) ?>
										</td>
										<td style="vertical-align: middle">
											<strong><?= $client->getTitle() ?></strong>
										</td>
										<td style="width: 120px">
											<?= $auth->isConnected($client) ?
												Html::a(Yii::t('user', 'Disconnect'), $auth->createClientUrl($client), [
													'class' => 'btn btn-danger btn-block',
													'data-method' => 'post',
												]) :
												Html::a(Yii::t('user', 'Connect'), $auth->createClientUrl($client), [
													'class' => 'btn btn-success btn-block',
												])
											?>
										</td>
									</tr>
								<?php endforeach; ?>
							</table>
							<?php Connect::end() ?>
							<br>
							<?php if (Yii::$app->getModule('user')->enableFlashMessages) : ?>
								<?php foreach (Yii::$app->session->getAllFlashes() as $type => $message) : ?>
									<?php if (in_array($type, ['success', 'danger', 'warning', 'info'])) : ?>
										<?= is_array($message) ? $message[0] : $message ?>
									<?php endif ?>
								<?php endforeach ?>
							<?php endif; ?>
							<br>
							<div class="tg-wrap"><img src="/img/tg.png" style="width:32px" class="tg-img">&nbsp;&nbsp;<a class="tg-a" href="tg://resolve?domain=domopta_bot&start=<?php echo Yii::$app->user->identity->auth_key ?>">Подписаться на Telegram</a>
							</div>
						</div>
					</div>
				</div>
			</div> */ ?>
		</div>
	</div>
</div>