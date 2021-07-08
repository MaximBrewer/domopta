<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\console\Controller;
use yii\httpclient\Client;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class HelloController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     */
    public function actionIndex($message = 'hello world')
    {
		// $curl = new Client();
		// $response = $curl->createRequest()
		//                  ->setHeaders([
		// 	                 'Content-Type: application/json',
		// 	                 'Accept: application/json',
		// 	                 'Authorization: Token d1f1cc1d2f8b283837831c90c7f5d8e1b33776da'
		//                  ])
		//                  ->setData(['query' => "910303905016"])
		//                  ->setUrl('https://suggestions.dadata.ru/suggestions/api/4_1/rs/findById/party')
		//                  ->send();
		// $data = $response->data;$lastname = explode(' ',$data['suggestions'][0]['data']['name']['full'])[0];
        // var_dump(mb_strtolower('НовакоВА') === mb_strtolower($lastname));
    }
}
