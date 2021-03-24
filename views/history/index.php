<?php
/* @var $this \yii\web\View */
/* @var $orders \app\models\Order[] */

use app\models\Products;
?>
<div class="content content_flip main__content">
	<div class="container container_fl-wr">
		<div class="content-left">
			<div class="history-main">
				<div class="content__title">ИСТОРИЯ ЗАКАЗОВ</div>
				<div class="finger">
					<div class="finger__icon">
						<svg class="finger__svg">
							<use xlink:href="/img/sprite-sheet.svg#finger" />
						</svg>
					</div>
					<div class="finger__text">
						Если не видно таблицы целиком сделайте слайд по экрану пальцем вправо или в лево
					</div>
				</div>
				<ul class="history-main__list">
					<div class="table-history">
						<table>
							<thead>
								<tr>
									<th class="text-center">Дата</th>
									<th class="text-center">Кол-во всего,&nbsp;шт.</th>
									<th class="text-center">Сумма,&nbsp;руб</th>
									<th class="text-center">подробности заказа</th>
								</tr>
							</thead>
							<?php foreach ($orders as $order) : ?>
								<tbody class="history-main__item <?php echo $order->status; ?>">
									<tr>
										<td class="text-center"><?php echo Yii::$app->formatter->asDate($order->created_at, 'php:d.m.Y') ?></td>
										<td class="text-center"><?php echo $order->getAmount() ?></td>
										<td class="text-center"><?php echo Products::formatPrice($order->getSum()); ?> </td>
										<td class="text-center" style="width:1px;">
											<div class="history-btn">
												<div class="btn-black history-main__btn-black">
													<a href="/history/detail?id=<?php echo $order->id ?>" class="btn-black__link">Подробности</a>
												</div>
												<?php if ($order->status == 'pending') : ?>
													<div class="btn-black history-main__btn-black">
														<a title="Отменить заказ" href="javascript:;" onclick='cancelOrder(<?php echo $order->id ?>)' class="cancel-order">&times;</a>
													</div>
												<?php elseif ($order->status == 'cancel') : ?>
													<div class="btn-black history-main__btn-black">
														<a title="Восстановить заказ" href="/history/return?id=<?php echo $order->id ?>" class="cancel-order">+</a>
													</div>
												<?php endif; ?>
											</div>
										</td>
									</tr>
								</tbody>
							<?php endforeach; ?>
						</table>
					</div>
				</ul>
			</div>
		</div>
		<div class="content-right">
			<div class="user-btns">
				<div class="content__title">Личный кабинет</div>
				<div class="drop-content content-btn__drop-content drop-content_phone">
					<a href="#" class="drop-content__link" id="cab">
						<div class="drop-content__text">
							<span>Личный кабинет</span>
							<div class="drop-content__icon">
								<svg class="svg drop-content__svg drop-content__svg_arrow2-dn">
									<use xlink:href="/img/sprite-sheet.svg#arrow2-dn" />
								</svg>
							</div>
						</div>
					</a>
				</div>
				<ul class="user-btns__list">
					<li class="user-btns__item">
						<a href="/cabinet" class="user-btns__link">Мой профиль</a>
					</li>
					<li class="user-btns__item user-btns__item_active">
						<a href="/history" class="user-btns__link">История заказов</a>
					</li>
					<li class="user-btns__item">
						<a href="/favorites" class="user-btns__link">Избранное</a>
					</li>
					<li class="user-btns__item">
						<a href="/site/logout" class="user-btns__link">Выход</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>
<div class="cart_popup_overley"></div>
<div class="container container_pop-small cart_popup history_cancel">
	<div class="reg-pop-inner reg-pop-inner-cart">
		<div class="cart_popup_clean">
			<h2>Отменить заказ</h2>
			<h3>Вы уверены, что хотите отменить заказ?</h3>
			<div class="cart_popup_btn">
				<a href="javascript:;" class="btn-black__link cancel-href">Да</a>
				<a href="javascript:;" class="btn-black__link close-h">Нет</a>
			</div>
		</div>
		<a href="#" id="esc" class="esc close-h">
			<div class="esc__icon esc__icon_cross1">
				<svg class="svg esc__svg esc__svg_cross1">
					<use xlink:href="/img/sprite-sheet.svg#cross1" />
				</svg>
			</div>
		</a>
	</div>
</div>