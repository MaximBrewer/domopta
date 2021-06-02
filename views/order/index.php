<?php

/**
 * @var $this \yii\web\View
 * @var $cart \app\models\Cart[]
 */

use yii\grid\GridView;
use yii\helpers\Html;
use yii\grid\ActionColumn;
use app\components\Breadcrumbs;
use app\models\Products;
use yii\widgets\MaskedInput;

// $this->registerJsFile('/js/cart.js', ['depends' => \yii\web\JqueryAsset::className()]);
// var_dump($order->errors);
$this->params['breadcrumbs'][] = 'Оформление';
?>

<div class="content content_flip main__content">
  <div class="container container_fl-wr">
    <div class="content-left">
      <div class="order-main main__order-main">
        <form method="post" id="sendOrderForm">
          <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>" value="<?= Yii::$app->request->getCsrfToken(); ?>" />
          <input type="hidden" name="delivery_method" id="delivery_method" value="<?php echo $order->delivery_method; ?>" />
          <div class="content__title">ДОСТАВКА</div>
          <div class="delivery-item delivery-item_enter-1" <?php echo $order->delivery_method == 'pickup' ? ' delivery-item_active' : '' ?> data-method="pickup">
            <div class="delivery-item__wr delivery_js">
              <p class="delivery-item__title">Самовывоз</p>
            </div>
            <div class="delivery-item__wr delivery-item__wr_btn">
              <?php echo $order->delivery_method == 'pickup' ? '<button class="order-btn order-btn_sumbmit  mr-5">Оформить заказ</button>&nbsp;<button type="button" class="order-btn delivery_js order-btn_js order-btn_active">Выбран</button>' : '<button class="order-btn order-btn_sumbmit  mr-5" style="display:none">Оформить заказ</button>&nbsp;<button type="button" class="order-btn delivery_js order-btn_js">Выбрать</button>'; ?>
            </div>
          </div>
          <div class="delivery-item delivery-item_enter-2<?php echo $order->delivery_method == 'delivery' ? ' delivery-item_active' : '' ?>" data-method="delivery">
            <div class="delivery-item__wr">
              <div class="delivery-item__title-wr delivery_js ">
                <p class="delivery-item__title">Доставка по Крыму</p>
                <svg class="icon-edit" width="15" height="9" viewBox="0 0 15 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M14.8167 0.62077C14.5724 0.37641 14.1774 0.37641 13.933 0.62077L7.49998 7.05376L1.06699 0.62077C0.822631 0.37641 0.42763 0.37641 0.18327 0.62077C-0.06109 0.86513 -0.06109 1.26013 0.18327 1.50449L7.05813 8.37935C7.18 8.50123 7.33999 8.56248 7.50001 8.56248C7.66002 8.56248 7.82001 8.50123 7.94188 8.37935L14.8167 1.50449C15.0611 1.26013 15.0611 0.86513 14.8167 0.62077Z" fill="black" />
                </svg>
              </div>
            </div>
            <div class="delivery-item__body">
              <div class="delivery-item__wr ">
                <label class="label-input<?php if (!empty($order->errors['locality'])) echo ' error'; ?>">
                  <span>Укажите населенный пункт</span>
                  <input type="text" name="locality" value="<?php echo $order->locality; ?>">
                  <?php if (!empty($order->errors['locality'])) :
                    foreach ($order->errors['locality'] as $error) : ?>
                      <div class="error"><?= $error; ?></div>
                  <?php endforeach;
                  endif; ?>
                </label>
              </div>
              <hr>
              <div class="delivery-item__wr delivery-item__wr_col">
                <p class="delivery-item__title">Данные получателя заказа</p>
                <div class="label-input-wr label-input-wr_row">
                  <label class="label-input<?php if (!empty($order->errors['fio'])) echo ' error'; ?>">
                    <span>Фамилия Имя Отчество получателя груза</span>
                    <input type="text" name="fio" value="<?php echo $order->fio; ?>">
                    <?php if (!empty($order->errors['fio'])) :
                      foreach ($order->errors['fio'] as $error) : ?>
                        <div class="error"><?= $error; ?></div>
                    <?php endforeach;
                    endif; ?>
                  </label>
                  <label class="label-input<?php if (!empty($order->errors['phone'])) echo ' error'; ?>">
                    <span>Телефон</span>
                    <?php echo MaskedInput::widget([
                      'name' => 'phone',
                      'value' => $order->phone,
                      'mask' => '+7 (999) 999-99-99',
                      'options' => ['placeholder' => 'ВВЕДИТЕ номер телефона'],
                      'clientOptions' => [
                        'placeholder' => ' '
                      ]
                    ]) ?>
                    <?php if (!empty($order->errors['phone'])) :
                      foreach ($order->errors['phone'] as $error) : ?>
                        <div class="error"><?= $error; ?></div>
                    <?php endforeach;
                    endif; ?>
                  </label>
                </div>

              </div>
            </div>
            <div class="delivery-item__wr delivery-item__wr_btn">

              <?php echo $order->delivery_method == 'delivery' ? '<button class="order-btn order-btn_sumbmit  mr-5">Оформить заказ</button>&nbsp;<button type="button" class="order-btn delivery_js order-btn_js order-btn_active">Выбран</button>' : '<button class="order-btn order-btn_sumbmit  mr-5" style="display:none">Оформить заказ</button>&nbsp;<button type="button" class="order-btn delivery_js order-btn_js">Выбрать</button>'; ?>
            </div>
          </div>
          <div class="delivery-item delivery-item_enter-3<?php echo $order->delivery_method == 'sending' ? ' delivery-item_active' : '' ?>" data-method="sending">
            <div class="delivery-item__wr delivery-item__wr_first">
              <div class="delivery-item__title-wr delivery_js ">
                <p class="delivery-item__title">ОТПРАВКА ТРАНСПОРТНОЙ КОМПАНИЕЙ</p>
                <svg class="icon-edit" width="15" height="9" viewBox="0 0 15 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M14.8167 0.62077C14.5724 0.37641 14.1774 0.37641 13.933 0.62077L7.49998 7.05376L1.06699 0.62077C0.822631 0.37641 0.42763 0.37641 0.18327 0.62077C-0.06109 0.86513 -0.06109 1.26013 0.18327 1.50449L7.05813 8.37935C7.18 8.50123 7.33999 8.56248 7.50001 8.56248C7.66002 8.56248 7.82001 8.50123 7.94188 8.37935L14.8167 1.50449C15.0611 1.26013 15.0611 0.86513 14.8167 0.62077Z" fill="black" />
                </svg>
              </div>
            </div>
            <div class="delivery-item__body">
              <div class="delivery-item__wr">
                <div class="label-input-wr label-input-wr_row">
                  <label class="label-radio">
                    <input type="radio" name="tc" value="kit" <?php echo $order->tc == 'kit' ? ' checked="true"' : '' ?>>
                    <div class="round-input"><span class="round-input-checked"></span></div>
                    <span class="label-radio__text">GTD (КИТ) </span>
                  </label>
                  <label class="label-radio">
                    <input type="radio" name="tc" value="pek" <?php echo $order->tc == 'pek' ? ' checked="true"' : '' ?>>
                    <div class="round-input"><span class="round-input-checked"></span></div>
                    <span class="label-radio__text">ПЭК</span>
                  </label>
                  <!-- <label class="label-radio">
                    <input type="radio" name="tc" value="zde" <?php echo $order->tc == 'zde' ? ' checked="true"' : '' ?>>
                    <div class="round-input"><span class="round-input-checked"></span></div>
                    <span class="label-radio__text">ЖелДорЭкспедиция</span>
                  </label> -->
                  <label class="label-radio">
                    <input type="radio" name="tc" value="magic" <?php echo $order->tc == 'magic' ? ' checked="true"' : '' ?>>
                    <div class="round-input"><span class="round-input-checked"></span></div>
                    <span class="label-radio__text">Мейджик Транс</span>
                  </label>
                  <label class="label-radio">
                    <input type="radio" name="tc" value="other" <?php echo $order->tc == 'other' ? ' checked="true"' : '' ?>>
                    <div class="round-input"><span class="round-input-checked"></span></div>
                    <span class="label-radio__text">Иная ТК</span>
                  </label>
                </div>
              </div>
              <?php if (!empty($order->errors['tc'])) :
                foreach ($order->errors['tc'] as $error) : ?>
                  <div class="label-input error">
                    <div class="delivery-item__wr required error"><?= $error; ?></div>
                  </div>
              <?php endforeach;
              endif; ?>
              <div class="delivery-item__wr delivery-item__wr_col" id="tc_name" style="display:<?php echo $order->tc == 'other' ? 'block' : 'none'; ?>">
                <div class="label-input-wr label-input-wr_row">
                  <label class="label-input<?php if (!empty($order->errors['tc_name'])) echo ' error'; ?>" style="margin-top:0;">
                    <span>Название ТК</span>
                    <input type="text" name="tc_name" value="<?php echo $order->tc_name; ?>">
                    <?php if (!empty($order->errors['tc_name'])) :
                      foreach ($order->errors['tc_name'] as $error) : ?>
                        <div class="error"><?= $error; ?></div>
                    <?php endforeach;
                    endif; ?>
                  </label>
                </div>
              </div>
              <hr>
              <div class="delivery-item__wr delivery-item__wr_col">
                <p class="delivery-item__title">Данные получателя заказа</p>
                <div class="label-input-wr label-input-wr_row">
                  <label class="label-input<?php if (!empty($order->errors['fio'])) echo ' error'; ?>">
                    <span>Фамилия Имя Отчество получателя груза</span>
                    <input type="text" name="fio2" value="<?php echo $order->fio; ?>">
                    <?php if (!empty($order->errors['fio'])) :
                      foreach ($order->errors['fio'] as $error) : ?>
                        <div class="error"><?= $error; ?></div>
                    <?php endforeach;
                    endif; ?>
                  </label>
                  <label class="label-input<?php if (!empty($order->errors['phone'])) echo ' error'; ?>">
                    <span>Телефон</span>
                    <?php echo MaskedInput::widget([
                      'name' => 'phone2',
                      'value' => $order->phone,
                      'mask' => '+7 (999) 999-99-99',
                      'options' => ['placeholder' => 'ВВЕДИТЕ номер телефона'],
                      'clientOptions' => [
                        'placeholder' => ' '
                      ]
                    ]) ?>
                    <?php if (!empty($order->errors['phone'])) :
                      foreach ($order->errors['phone'] as $error) : ?>
                        <div class="error"><?= $error; ?></div>
                    <?php endforeach;
                    endif; ?>
                  </label>
                </div>
                <div class="label-input-wr label-input-wr_row label-input-wr_small">
                  <label class="label-input label-input_serial-passport<?php if (!empty($order->errors['passport_series'])) echo ' error'; ?>">
                    <span>Серия паспорта</span>
                    <input type="text" name="passport_series" value="<?php echo $order->passport_series; ?>">
                    <?php if (!empty($order->errors['passport_series'])) :
                      foreach ($order->errors['passport_series'] as $error) : ?>
                        <div class="error"><?= $error; ?></div>
                    <?php endforeach;
                    endif; ?>
                  </label>
                  <label class="label-input label-input_numb-passport<?php if (!empty($order->errors['passport_id'])) echo ' error'; ?>">
                    <span>Номер паспорта</span>
                    <input type="text" name="passport_id" value="<?php echo $order->passport_id; ?>">
                    <?php if (!empty($order->errors['passport_id'])) :
                      foreach ($order->errors['passport_id'] as $error) : ?>
                        <div class="error"><?= $error; ?></div>
                    <?php endforeach;
                    endif; ?>
                  </label>
                </div>
                <div class="label-input-wr label-input-wr_row label-input-wr_small">
                  <label class="label-input label-input_city<?php if (!empty($order->errors['city'])) echo ' error'; ?>">
                    <span>Город</span>
                    <input type="text" name="city" value="<?php echo $order->city; ?>">
                    <?php if (!empty($order->errors['city'])) :
                      foreach ($order->errors['city'] as $error) : ?>
                        <div class="error"><?= $error; ?></div>
                    <?php endforeach;
                    endif; ?>
                  </label>
                  <label class="label-input label-input_region<?php if (!empty($order->errors['region'])) echo ' error'; ?>">
                    <span>Область</span>
                    <input type="text" name="region" value="<?php echo $order->region; ?>">
                    <?php if (!empty($order->errors['region'])) :
                      foreach ($order->errors['region'] as $error) : ?>
                        <div class="error"><?= $error; ?></div>
                    <?php endforeach;
                    endif; ?>
                  </label>
                </div>
              </div>
            </div>
            <div class="delivery-item__wr delivery-item__wr_btn ">
              <?php echo $order->delivery_method == 'sending' ? '<button class="order-btn order-btn_sumbmit  mr-5">Оформить заказ</button>&nbsp;<button type="button" class="order-btn delivery_js order-btn_js order-btn_active">Выбран</button>' : '<button class="order-btn order-btn_sumbmit  mr-5" style="display:none">Оформить заказ</button>&nbsp;<button type="button" class="order-btn delivery_js order-btn_js">Выбрать</button>'; ?>
            </div>
          </div>
          <div class="delivery-item__wr delivery-item__wr_line">
            <div class="">
              <p class="delivery-error">Выберите один из вариантов доставки</p>
            </div>
            <div class="">
              <a class="order-btn" href="/cart">Назад</a>
              <button class="order-btn order-btn_sumbmit ">Оформить заказ</button>
            </div>
          </div>
        </form>
      </div>
    </div>
    <script>
      document.querySelectorAll('.delivery_js').forEach(function(item, idx, arr) {
        item.addEventListener('click', function() {

          var inputsFromd = document.getElementById('sendOrderForm').getElementsByTagName('input')

          for (var i = 0; i < inputsFromd.length; i++) {
            if (inputsFromd[i].type == 'text' || inputsFromd[i].type == 'email' || inputsFromd[i].type == 'phone' || !inputsFromd[i].type) {
              if (inputsFromd[i].closest('.label-input'))
                inputsFromd[i].closest('.label-input').classList.remove('error');
            }
          }

          let parent = item.closest('.delivery-item');
          for (let i = 0; i < arr.length; i++) {
            if (arr[i].closest('.delivery-item').classList.contains('delivery-item_active')) {
              arr[i].closest('.delivery-item').classList.remove('delivery-item_active')
              arr[i].closest('.delivery-item').querySelector('.mr-5').style.display = 'none'
            }
            if (arr[i].classList.contains('order-btn_active'))
              arr[i].classList.remove('order-btn_active')
            if (arr[i].innerHTML === "Выбран")
              arr[i].innerHTML = "Выбрать";
            if (document.querySelector('.delivery-error').classList.contains('delivery-error_active')) {
              document.querySelector('.delivery-error').classList.remove('delivery-error_active')
            }
          }
          // scrollTo(0, document.querySelector('.delivery-item').getBoundingClientRect()["top"])
          item.closest('.delivery-item').querySelector('.order-btn_js').classList.toggle('order-btn_active')
          if (item.closest('.delivery-item').querySelector('.order-btn_js').innerHTML === "Выбрать") {
            item.closest('.delivery-item').querySelector('.order-btn_js').innerHTML = "Выбран";
            item.closest('.delivery-item').querySelector('.mr-5').style.display = 'block';
            document.getElementById('delivery_method').value = item.closest('.delivery-item').dataset.method;
          } else {
            item.closest('.delivery-item').querySelector('.mr-5').style.display = 'none';
            item.closest('.delivery-item').querySelector('.order-btn_js').innerHTML = "Выбрать";
          }
          parent.classList.toggle('delivery-item_active')
        });
      });

      var inputsFrom = document.getElementById('sendOrderForm').getElementsByTagName('input')

      for (var i = 0; i < inputsFrom.length; i++) {
        inputsFrom[i].addEventListener('input', function(event) {
          if (this.closest('.label-input'))
            this.closest('.label-input').classList.remove('error');
        });
        inputsFrom[i].addEventListener('keydown', function(event) {
          if (this.closest('.label-input'))
            this.closest('.label-input').classList.remove('error');
        });
      }

      document.getElementById('sendOrderForm').addEventListener('submit', function(event) {
        event.preventDefault();
        if (document.getElementById('delivery_method').value) {
          this.submit();
        } else {
          document.querySelector('.delivery-error').classList.add('delivery-error_active');
        }
      });
    </script>
    <div class="content-right">
      <div class="user-btns">
        <div class="content__title">Личный кабинет</div>
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