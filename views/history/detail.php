<?php
/* @var $this \yii\web\View */
/* @var $order \app\models\Order */

use app\models\Products;
?>
<?php
$products = [];
foreach ($order->detiles as $item) {
	if (!$item->product) continue;
	$products[$item->product->id]['product'] = $item->product;
	$products[$item->product->id]['colors'][] = $item;

}
?>
<div class="content content_flip main__content">
	<div class="container container_fl-wr">
		<div class="content-left">
			<div class="cart-main main__cart-main">
				<div class="content__title" style="max-width:100%;">Подробности заказа
					<?php if (isset($order->status) && $order->status == 'cancel') : ?>
						<span style="color:red;text-transform:uppercase">
							(Данный заказ отменён)
						</span>
					<?php endif; ?>
				</div>
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
				<div class="cart-main-middle">
					<ul class="cart-main__list">
						<div class="table-cart">
							<table>
								<thead>
									<tr>
										<th>Товар</th>
										<th>Цвет / размер</th>
										<th>Цена (шт)</th>
										<th>кол-во</th>
										<th>сумма</th>
									</tr>
								</thead>
								<tbody class="cart-main__item">
									<?php foreach ($products as $item1) :
									?>
										<tr>
											<td rowspan="<?php echo count($item1['colors']) + 1 ?>" class="first-td">
												<a href="<?php echo $item1['product']->slug ?>">
													<div class="photos-tovar__item cart-main__pic">
														<img src="<?php echo isset($item1['product']->pictures[0]) ? $item1['product']->pictures[0]->getUrl('small') : '/img/d.jpg' ?>" alt="img" class="photos-tovar-cart__img cart-main__img">
													</div>
													<span><?php echo $item1['product']->article ?></span>
												</a>
											</td>
											<td colspan="4" class="cart-main__item-desc"><span><?php echo $item1['product']->name ?></span></td>
										</tr>
										<?php foreach ($item1['colors'] as $item) : ?>
											<tr>
												<td><?php
													$str = $item->color != 'default' ? $item->color : '';
													echo $str;
													?></td>
												<td><?php
													$str = Products::formatPrice($item->price);

													echo $str;
													?></td>
												<td><?php $str = $item->amount;
													echo $str;
													?></td>

												<td>
													<?php
													$str = Products::formatPrice($item->sum);

													echo $str;
													?>
												</td>
											</tr>
										<?php endforeach; ?>
										<tr>
											<td colspan="8" class="td-bottom">
												Примечание: <?php echo $item->memo ?>
											</td>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						</div>
					</ul>
				</div>
			</div>
			<div style="display:flex;justify-content:flex-end;">
				<a class="btn-black__link" href="/history/xls?id=<?php echo $order->id; ?>" target="_blank">Скачать заказ (xls)</a>
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
					<li class="user-btns__item">
						<a href="/history" class="user-btns__link">История заказов</a>
					</li>
					<li class="user-btns__item">
						<a href="/favorites" class="user-btns__link">Избранное</a>
					</li>
					<li class="user-btns__item">
						<a href="/cabinet/password" class="user-btns__link">Смена пароля</a>
					</li>
					<li class="user-btns__item">
						<a href="/cabinet/csv" target="_blank" class="user-btns__link">Скачать каталог (CSV)</a>
					</li>
					<li class="user-btns__item">
						<a href="/cabinet/xml" target="_blank" class="user-btns__link">Скачать каталог (XML)</a>
					</li>
					<li class="user-btns__item">
						<a class="user-btns__link" href="/site/logout" alt="Выход" title="Выход" data-confirm="Вы действительно хотите выйти?" data-method="get" data-popup="logout_popup">Выход</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>