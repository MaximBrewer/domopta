<?php

/**
 * Created by PhpStorm.
 * User: resh
 * Date: 25.01.19
 * Time: 18:03
 */

namespace app\models;


use yii\httpclient\Client;
use app\models\Profile;

class InnValidator
{

	public static function validate(User $user, Profile $profile)
	{
		if ($profile->type == 2) return true;

		// $p = Profile::findOne(['inn' => $profile->inn]);
		// if ($p) {
		// 	$profile->addError('inn', 'Извините, но данный ИНН / ОГРН ' . $profile->inn . ' уже зарегистрирован на сайте. <br /> Возможно, это ошибка. <br /> Для решения данного вопроса обратитесь в Администрацию, по указанным телефонам на сайте.');
		// 	return false;
		// }

		// $curl = new Client();
		// $response = $curl->createRequest()
		// 	->setHeaders([
		// 		'Content-Type: application/json',
		// 		'Accept: application/json',
		// 		'Authorization: Token d1f1cc1d2f8b283837831c90c7f5d8e1b33776da'
		// 	])
		// 	->setData(['query' => $profile->inn])
		// 	->setUrl('https://suggestions.dadata.ru/suggestions/api/4_1/rs/findById/party')
		// 	->send();
		// $data = $response->data;
		// //		if(!isset($data['suggestions']) || empty($data['suggestions']) || $data['suggestions'][0]['data']['state']['status'] != 'ACTIVE'){
		// if (!isset($data['suggestions']) || empty($data['suggestions'])) {
		// 	$profile->addError('inn', 'Данное юр.лицо закрыто или не существует');
		// 	return false;
		// }
		// $type = $data['suggestions'][0]['data']['type'];
		//		echo '<pre>' . print_r($data['suggestions'][0]['data'], 1) . '</pre>'; die();
		// if ($type == 'INDIVIDUAL') {
		// 	$lastname = $data['suggestions'][0]['data']['fio']['surname'];
		// 	if (mb_strtolower($profile->lastname) != mb_strtolower($lastname)) {
		// 		$profile->addError('inn', 'Фамилия не соответствует ИНН/ОГРН');
		// 		return false;
		// 	}
		// } elseif ($type == 'LEGAL') {
		// 	$title = $data['suggestions'][0]['unrestricted_value'];
		// 	if (mb_strtolower($profile->organization_name) != mb_strtolower($title)) {
		// 		$profile->addError('inn', 'Название организации не соответствует ИНН/ОГРН');
		// 		return false;
		// 	}
		// }

		return true;
	}
}
