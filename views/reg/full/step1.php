<?php

/**
 * Created by PhpStorm.
 * User: resh
 * Date: 23.01.19
 * Time: 12:56
 */
/* @var $this \yii\web\View */
/* @var $user \app\models\User */
/* @var $profile \app\models\Profile */
/* @var $form \yii\widgets\ActiveForm */

use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>
<div class="content">
    <!-- <div class="container reg-step-1">
		<div class="col-sm-4">Предприниматели<br><a href="/reg/full?step=1&type=1">Зарегистрироваться</a></div>
		<div class="col-sm-4">ООО<br><a href="/reg/full?step=1&type=3">Зарегистрироваться</a></div>
		<div class="col-sm-4">Физики<br><a href="/reg/full?step=1&type=2">Зарегистрироваться</a></div>
	</div> -->

    <div class="container container_fl-wr">

        <div class="register">
            <!-- <div class="register-top">
                <div class="content__title">РЕГИСТРАЦИЯ <span>(Шаг 2 из 3)</span></div>
                <div class="register-alert">
                    <p> <strong>Обязательно</strong> ознакомьтесь с Условиями Работы!</p>
                    <a class="register__btn" href="/uslovia-raboty">читать условия работы</a>
                </div>
                 /.register-alert
            </div> -->
            <div class="register-bottom">
                <div class="reg-step2-wrap">
                    <!-- /.reg-step2-item -->
                    <div class="reg-step2-item">
                        <img src="/img/reg-step2-item-img2.png" alt="" class="reg-step2-item-img">
                        <!-- /.reg-step2-item-img -->
                        <div class="reg-step2-item-tetle">Предприниматели (ИП)<br/>Юридические лица (ООО)</div>
                        <!-- /.reg-step2-item-tetlу -->
                        <ul class="reg-step2-item-info">
                            <li>Тип цен: Опт</li>
                            <li>По завершении регистрации видны только оптовые цены;</li>
                            <li>При регистрации необходимо будет заполнить регистрационные данные Юридического лица (ООО) или Предпринимателя (ИП);</li>
                            <li>Заказы формируются<br>от 10.000 рублей для ООО и от 7.000 рублей для ИП;</li>
                            <li>Форма оплаты:<br>безналичный расчет для ООО, наличный и безналичный расчет для ИП;</li>
                            <li>Отправка заказов осуществляется<br>Транспортными Компаниями;</li>
                            <li>Бесплатная доставка<br>по городам Крыма;</li>
                            <li>Действует система скидок!</li>
                        </ul>
                        <!-- /.reg-step2-item-info -->
                        <div class="reg-step2-item-button register__btn"><a href="/reg/full?step=1&type=3">продолжить регистрацию</a></div>
                        <!-- /.reg-step2-item-button -->
                    </div>
                    <!-- /.reg-step2-item -->
                    <div class="reg-step2-item">
                        <img src="/img/reg-step2-item-img3.png" alt="" class="reg-step2-item-img">
                        <!-- /.reg-step2-item-img -->
                        <div class="reg-step2-item-tetle">Физические лица</div>
                        <!-- /.reg-step2-item-tetlу -->
                        <ul class="reg-step2-item-info">
                            <li>Тип цен: Мелкий Опт</li>
                            <li>По завершении регистрации видны только мелкооптовые цены;</li>
                            <li>При регистрации необходимо будет заполнить только контактную информацию;</li>
                            <li>Заказы формируются<br>от 3.000 рублей;</li>
                            <li>Форма оплаты:<br>наличный и безналичный расчет;</li>
                            <li>Отправка заказов осуществляется<br>Транспортными Компаниями;</li>
                            <li>Действует система скидок!</li>
                            <li>&nbsp;<br>&nbsp;</li>
                        </ul>
                        <!-- /.reg-step2-item-info -->
                        <div class="reg-step2-item-button register__btn"><a href="/reg/full?step=1&type=2">продолжить регистрацию</a></div>
                        <!-- /.reg-step2-item-button -->
                    </div>
                    <!-- /.reg-step2-item -->
                </div>
                <!-- /.reg-step2-wrap -->
            </div>
        </div>
    </div>