<?php
if (!function_exists('curl_file_create')) {
    function curl_file_create($filename, $mimetype = '', $postname = '') {
        return "@$filename;filename="
            . ($postname ?: basename($filename))
            . ($mimetype ? ";type=$mimetype" : '');
    }
}
$user_name_vk  = explode("k.com/id", $_POST['vk_user_id']);
//print_r($user_name_vk); die();
if (count($user_name_vk) == 1 ){ // Если VK аккаунт вида https://vk.com/ivan_ivanov
	$domain_arr  = explode("vk.com/", $_POST['vk_user_id']);
	$domain = $domain_arr['1'];
	$user_id = '';
} elseif (count($user_name_vk) == 2 ) { // Если VK аккаунт вида https://vk.com/id209559514
	$domain = '';
	$user_id = $user_name_vk['1'];
}	


if ($_FILES['upload_file']['error'] != 0){ // если не прикреплен файл или есть ошибки- отправка обычного сообщения
	$request_params =[
		'user_id' =>$user_id, //кому отправлять
		'random_id' => mt_rand(20, 99999999),
		'peer_id' =>'29680439', 
		'domain' =>$domain, //кому отправлять
		'chat_id'=>'136',
		'message'=>$_POST['vk_mesage'], 
		'access_token'=>'115deeef20c2c0eb053b1464cfa285317a3f98e04797d05fba4d2d7bd59f450da36918b530961a718a2ef',
		'v' => '5.92'
	];
	$url = 'https://api.vk.com/method/messages.send?' . http_build_query($request_params);
	file_get_contents($url);
	echo $url;
} 
elseif ($_FILES['upload_file']['error'] == 0) { // если в приложении идет картинка
	
	print_r($_FILES);
	
	// ограничение размера файла
    $limit_size = 3*1024*1024; // 3 Mb
    // корректные форматы файлов
    $valid_format = array("jpg","png");
    // хранилище ошибок
    $error_array = array();
    // путь до нового файла
    $path_file = "tmp/";
    // имя нового файла
    $rand_name = md5(time() . mt_rand(0, 9999));
	// валидация размера файла
	if($_FILES["upload_file"]["size"] > $limit_size){
		$error_array[] = "Размер файла превышает допустимый!";
	}
	// валидация формата файла
	$format = end(explode(".", $_FILES["upload_file"]["name"]));
	if(!in_array($format, $valid_format)){
		$error_array[] = "Формат файла не допустимый!";
	}
	// если не было ошибок
	if(empty($error_array)){
		// проверяем загружен ли файл
		if(is_uploaded_file($_FILES["upload_file"]["tmp_name"])){
			// сохраняем файл
			move_uploaded_file($_FILES["upload_file"]["tmp_name"], $path_file . $rand_name . ".".$format);
		}else{
			// Если файл не загрузился
			$error_array[] = "Ошибка загрузки!";
		} 
	}
	if (isset ($error_array[0])) echo $error_array[0];	
	if (isset ($error_array[1])) echo $error_array[1];
	if (isset ($error_array[2])) echo $error_array[2];
	if (isset ($error_array[3])) echo $error_array[3];
	$new_file_name = $path_file.$rand_name. ".".$format;

    

	$request_params =[
		'access_token'=>'115deeef20c2c0eb053b1464cfa285317a3f98e04797d05fba4d2d7bd59f450da36918b530961a718a2ef',
		'v' => '5.92'
	];
	$url = 'https://api.vk.com/method/photos.getMessagesUploadServer?' . http_build_query($request_params);
	$result = json_decode(file_get_contents($url), true);
	
	//print_r($result);
		$curl =curl_init();
		//$file = __DIR__.'/gala.png'; 
		$file = $new_file_name;
		$file = curl_file_create($file, mime_content_type($file),pathinfo($file)['basename']);
		curl_setopt($curl, CURLOPT_URL, $result['response']['upload_url']);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_HTTPHEADER, 'Content-type: multipart/form-data;charset=utf-8');
		curl_setopt($curl, CURLOPT_POSTFIELDS, ['file'=>$file]);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_TIMEOUT, 10);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
		
		$responce_image = json_decode(curl_exec($curl), true);
		curl_close($curl);
		
		//print_r($responce_image);
		
		$request_params =[
		'server'=>$responce_image['server'],
		'photo'=>$responce_image['photo'],
		'hash'=>$responce_image['hash'],
		'access_token'=>'115deeef20c2c0eb053b1464cfa285317a3f98e04797d05fba4d2d7bd59f450da36918b530961a718a2ef',
		'v' => '5.92'
	];
	
	$url = 'https://api.vk.com/method/photos.saveMessagesPhoto?'.http_build_query($request_params);
	$result_image = json_decode(file_get_contents($url), true);
		
	
	
	
	$request_params =[
		'user_id' =>$user_id, //кому отправлять
		'random_id' => mt_rand(20, 99999999),
		'peer_id' =>'29680439', 
		'domain' =>$domain, //кому отправлять
		'chat_id'=>'136',
		'attachment'=>'photo'.$result_image['response'][0]['owner_id'].'_'.$result_image['response'][0]['id'],
		'message'=>$_POST['vk_mesage'], 
		'access_token'=>'115deeef20c2c0eb053b1464cfa285317a3f98e04797d05fba4d2d7bd59f450da36918b530961a718a2ef',
		'v' => '5.92'
	];
	$url = 'https://api.vk.com/method/messages.send?' . http_build_query($request_params);
	file_get_contents($url);
	
	
}





	
	//echo $url;
		
		
		
		// Для получения прав
/*
	$permissions =[
		'notify', 'friends', 'photos', 'audio', 'video', 'docs', 'notes',
		'pages', 'status', 'wall', 'groups', 'messages', 'email', 'notifications',
		'stats', 'ads', 'market', 'offline'
	];
		
	$request_params =[
		'client_id' =>'6833336',
		'redirect_url'=>'https://oauth.vk.com/blank.html',
		'response_type'=>'token',
		'display'=>'page',
		'scope'=> implode(',',$permissions)
	];
	$url = 'https://oauth.vk.com/authorize?' . http_build_query($request_params);
	echo $url;
	die();

*/
?>