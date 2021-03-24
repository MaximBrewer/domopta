<?php
/**
 * Created by PhpStorm.
 * User: resh
 * Date: 08.02.19
 * Time: 16:17
 */

namespace app\models;



class Telegram
{
	public static function start($data){
		return self::login($data);
	}
	public static function login($data)
	{
		$token = $data['raw'];//берем токен который отправляем
		if ($token && $user = User::findOne(['auth_key' => $token])) {//сравниваем
			if ($user->tg_id) {
				return "Уважаемый $user->name, Вы уже авторизованы в системе. ";
			}
			$user->tg_id = $data['chat_id'];//сохраняем chat_id в бд
			$user->save();
			return "Добро пожаловать, $user->name. Вы успешно авторизовались!";
		} else {
			return "Извините, не удалось найти данный токен!";
		}
	}
}