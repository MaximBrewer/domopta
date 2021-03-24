<?php
/**
 * Created by PhpStorm.
 * User: resh
 * Date: 08.05.17
 * Time: 10:19
 */

namespace app\models;

use yii\base\Model;

class Settings extends Model
{

    public $contacts;
    public $addresses;

    public $min1;
    public $min2;
    public $min3;

    public $adminEmail;
    public $sellEmail;

    public $phone_call;
    public $phone_order;
    public $phone_admin;
    public $phone;

    public $time;
    public $schema;
    public $rekvizit;

    public $smtpHost;
    public $smtpEmail;
    public $smtpPassword;
    public $smtpPort;
    public $smtpEncryption;
    public $smtpStreamOptionsSslVerifyPeer;
    public $smtpStreamOptionsSslAllowSelfSigned;

    // 'host' => 'smtp.yandex.ru',
    // 'username' => 'domopta@domopta.ru',
    // 'password' => 'Y1HuAB-SS%qMOgxc1X@)',

    public $social_instagram;
    public $social_vk;
    public $social_whatsapp;
    public $social_viber;

    public $email_active;
    public $email_success;
    public $email_block;
    public $email_order;
    public $email_unblock;
    public $email_delete;
    public $email_confirm;

    public $notify_unactive;
    public $notify_noconfirmed;
    public $notify_product_absend;

    public $hint1;
    public $hint2;
    public $hint3;

    public $footer;

    public function rules()
    {
        return [
            [['contacts'], 'string', 'on' => 'main'],
            [['hint1', 'hint2','hint3',], 'string', 'on' => 'hint'],
            [['min1', 'min2','min3',], 'integer'],
            [['adminEmail', 'sellEmail'], 'email', 'on' => 'auth'],
            [['smtpEmail'], 'email', 'on' => 'mail'],
            [['smtpHost', 'smtpPassword', 'smtpPort', 'smtpEncryption'], 'string', 'on' => 'mail'],
            [['smtpStreamOptionsSslVerifyPeer', 'smtpStreamOptionsSslAllowSelfSigned'], 'boolean', 'on' => 'mail'],
            [['addresses', 'phone_call','time', 'schema', 'rekvizit', 'phone_order', 'phone_admin', 'social_instagram', 'social_viber', 'social_vk', 'social_whatsapp', 'phone', 'footer'], 'safe', 'on' => 'auth'],
            [['email_active', 'email_success', 'email_block', 'email_order', 'email_unblock', 'email_delete', 'email_confirm'], 'safe', 'on' => 'emails'],
            [['notify_unactive', 'notify_noconfirmed', 'notify_product_absend'], 'safe', 'on' => 'notify'],
        ];
    }

    public function fields()
    {
        return ['min1', 'min2', 'min3', 'time', 'schema', 'rekvizit','phone_call', 'phone_order', 'phone_admin', 'phone', 'contacts', 'addresses', 'adminEmail','smtpEmail', 'smtpPassword', 'smtpPort', 'smtpEncryption', 'smtpStreamOptionsSslVerifyPeer', 'smtpStreamOptionsSslAllowSelfSigned', 'smtpHost', 'sellEmail', 'email_active', 'email_success', 'email_block', 'email_order', 'email_unblock', 'email_delete', 'email_confirm', 'notify_unactive', 'notify_noconfirmed', 'notify_product_absend', 'social_instagram', 'social_viber', 'social_vk', 'social_whatsapp', 'hint1', 'hint2','hint3', 'footer'];
    }
    public function attributes()
    {
        return ['min1', 'min2', 'min3', 'time', 'schema', 'rekvizit','phone_call', 'phone_order', 'phone_admin', 'phone', 'contacts', 'addresses', 'adminEmail', 'smtpEmail','smtpHost','smtpPassword','smtpPort','smtpEncryption','smtpStreamOptionsSslVerifyPeer','smtpStreamOptionsSslAllowSelfSigned','sellEmail', 'email_active', 'email_success', 'email_block', 'email_order', 'email_unblock', 'email_delete', 'email_confirm', 'notify_unactive', 'notify_noconfirmed', 'notify_product_absend', 'social_instagram', 'social_viber', 'social_vk', 'social_whatsapp', 'hint1', 'hint2','hint3', 'footer'];
    }

    public function attributeLabels()
    {
        return [
            'min1' => 'Минимальный заказ для ИП (Опт)',
            'min2' => 'ФизЛицо (Мел/Опт)',
            'min3' => 'ООО (Опт)',
            'addresses' => 'Адрес',
            'contacts' => 'Контакты',
            'adminEmail' => 'Email администратора',
            'smtpHost' => 'SMTP Host',
            'smtpEmail' => 'SMTP Username',
            'smtpPassword' => 'SMTP Password',
            'smtpPort' => 'SMTP Port (587)',
            'smtpEncryption' => 'SMTP Encryption (tls)',
            'smtpStreamOptionsSslVerifyPeer' => 'SMTP Stream Option SSL Verify Peer (false)',
            'smtpStreamOptionsSslAllowSelfSigned' => 'SMTP Stream Option SSL Allow Self Signed (true)',
            'sellEmail' => 'Email отдел заказов',
            'email_active' => 'Отправляется пользователю при активации его учетной записи',
            'email_confirm' => 'Отправляется пользователю при успешной регистрации',
            'email_block' => 'Отправляется пользователю при блокировке его учетной записи',
            'email_order' => 'Отправляется пользователю при оформлении заказа',
            'email_unblock' => 'Отправляется пользователю при разблокировке его учетной записи',
            'email_delete' => 'Отправляется пользователю при удалении его учетной записи',
            'email_success' => 'Отправляется пользователю для подтверждения e-mail',
            'notify_unactive' => 'Сообщение неактивному пользователю',
            'notify_noconfirmed' => 'Сообщение пользователю с неподтверждённым email',
            'notify_product_absend' => 'Товар отсутствует (страница товара)',
            'phone_call' => 'Телефон горячей линии',
            'phone_order' => 'Телефон администрации',
            'phone_admin' => 'Телефон консультации',
	        'social_instagram' => 'Инстаграм',
	        'social_viber'  => 'Viber',
	        'social_vk'  => 'ВКонтакте',
	        'social_whatsapp'  => 'WhatsApp',
            'phone' => 'Телефон отдела заказов',
	        'time' => 'Время работы',
	        'schema' => 'Схема проезда',
	        'rekvizit' => 'Реквизиты',
            'hint1' => 'ПРЕДПРИНИМАТЕЛИ, ИП (ОПТОВЫЕ ЦЕНЫ)',
            'hint2' => 'ФИЗИЧЕСКИЕ ЛИЦА (МЕЛКООПТОВЫЕ ЦЕНЫ)',
            'hint3' => 'ЮРИДИЧЕСКИЕ ЛИЦА, ООО (ОПТОВЫЕ ЦЕНЫ)',
            'footer' => 'Текст в футере',
        ];
    }

}