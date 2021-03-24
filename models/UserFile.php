<?php
/**
 * Created by PhpStorm.
 * User: resh
 * Date: 23.01.19
 * Time: 14:37
 */

namespace app\models;


use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property int $user_id
 * @property string $filename
 */
class UserFile  extends ActiveRecord {

	public static function tableName() {
		return '{{%user_file}}';
	}

	public function rules() {
		return [
			['user_id', 'integer'],
			['filename', 'safe']
		];
	}

}