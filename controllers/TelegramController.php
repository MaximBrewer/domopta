<?php
/**
 *
 * bot: 849567722:AAFhuT2Nk6s4NaUzD_Y5hueKIB4B18-oHXc
 * domopta_bot
 *
 */

namespace app\controllers;


use app\models\Telegram;
use app\models\User;
use Telegram\Bot\Api;
use yii\filters\AccessControl;
use yii\web\Controller;

class TelegramController extends Controller {

	public function beforeAction($action)//Обязательно нужно отключить Csr валидацию, так не будет работать
	{
		$this->enableCsrfValidation = ($action->id !== "webhook");
		return parent::beforeAction($action);
	}

	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'only' => ['webhook'],
				'rules' => [
					[
						'allow' => true,
						'roles' => ['?'],
					],
				],
			],
		];
	}

	public function actionWebhook()
	{
		$data = json_decode(file_get_contents('php://input'), true);//Обязательно json формат
		if(isset($data['message']['chat']['id']))
		{
            $telegram = new Api('849567722:AAFhuT2Nk6s4NaUzD_Y5hueKIB4B18-oHXc');
			$chatId = $data['message']['chat']['id'];//Получаем chat_id
			$message = isset($data['message']['text']) ? $data['message']['text'] : false;

			$send = false;

			if (strpos($message, '/start') !== false) {//Возвращает позицию
				$explode = explode(' ', $message);//Разбивает строку на подстроки
				$token = isset($explode[1]) ? $explode[1] : false;//Получаем токен
				$data = [
					'raw' => $token,
					'chat_id' => $chatId,
				];
				$send = Telegram::start($data);//Сравниваем токен и если имеется схожесть то сохраняем telegram_chat_id в бд
                $telegram->sendMessage(['chat_id' => $chatId, 'text' => 'Вы подписались на оповещения domopta.ru']);
			} elseif(strpos($message, '/stop') !== false) {
			    User::updateAll(['tg_id' => ''], ['tg_id' => $chatId]);
                $telegram->sendMessage(['chat_id' => $chatId, 'text' => 'Вы успешно отписались']);
			}
			$send = $send ? '' : 'Что-то пошло не по плану. Обратитесь в тех.поддержку';
		}
	}

}