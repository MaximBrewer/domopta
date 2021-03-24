<?php
/**
 * Created by PhpStorm.
 * User: resh
 * Date: 25.01.19
 * Time: 18:31
 */

namespace app\models;


use dektrium\user\models\Account;
use Telegram\Bot\Api;
use yii\base\Model;
use yii\web\UploadedFile;

class SendForm extends Model {

	public $text;
	public $file;

	public function rules() {
		return [
			['text', 'safe'],
			['file', 'image']
		];
	}

	public function attributeLabels() {
		return [
			'text' => 'Текст',
			'file' => 'Файл',
		];
	} 


	public function process(){

//
//		$permissions =[
//			'notify', 'friends', 'photos', 'audio', 'video', 'docs', 'notes',
//			'pages', 'status', 'wall', 'groups', 'messages', 'email', 'notifications',
//			'stats', 'ads', 'market', 'offline'
//		];
//
//		$request_params =[
//			'client_id' =>'6852171',
//			'redirect_url'=>'https://oauth.vk.com/blank.html',
//			'response_type'=>'token',
//			'display'=>'page',
//			'scope'=> implode(',',$permissions)
//		];
//		$url = 'https://oauth.vk.com/authorize?' . http_build_query($request_params);
//		echo $url;
//		die();

		$text = $this->text;
		$file = UploadedFile::getInstance($this, 'file');

		/**
		 * Здесь идет произвольный код
		 */

		$vk_models = Account::findAll(['provider' => 'vkontakte']);
		foreach ($vk_models as $vk) {
			Vk::send($vk->client_id, $text, $file );
			sleep(1);
		}

		$tg_models = User::find()->where(['<>', 'tg_id', ''])->all();
		$telegram = new Api('849567722:AAFhuT2Nk6s4NaUzD_Y5hueKIB4B18-oHXc');
		foreach ($tg_models as $model){
            $telegram->sendMessage(['chat_id' => $model->tg_id, 'text' => $text]);
            if($file){
                $telegram->sendPhoto(['chat_id' => $model->tg_id, 'photo' => $file->tempName]);
            }
        }


//		 die();
//		 echo $_POST['SendForm']['text'];
//		 echo $_FILES['SendForm']['name']['file'];
		
//		 // получаю данные контактов из БД
//		$db_1 = mysqli_connect('localhost', 'lv', 'qazwsx12');
//		mysqli_select_db ( $db_1 , 'lv') or die ('Выбор БД не произошел: ' .mysql_error());
//		$query = "SELECT * FROM `vk`";
//		$result= mysqli_query($db_1, $query) or die('Не произошел выбор списка ВК из БД');
//		// Цикл  количеству контактов
//
//		echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>';
//		echo '<script type="text/javascript">';
//		while ($vk_arr = mysqli_fetch_assoc($result)){
//			echo '$.ajax({
//			url: "http://arhstyle.org/vk_yuri_bot.php",
//			data: {
//			  vk_user_id: "'.$vk_arr['vk_http'].'",
//			  vk_mesage: "123"
//			},
//			async: false,
//			success: function(){
//            alert("Запись о явке установлена");
//			},
//			error: function (data) {
//			  alert("Ошибка! Не удалось поставить запись о явке");
//			},
//			type: "POST",
//			dataType: "text"
//		 });';
//
//		}
//		 echo '</script>';
//		die();
		 
		 // получаю результат, выдаю на экран
		 // задержка времени
		 

		 
	}

}