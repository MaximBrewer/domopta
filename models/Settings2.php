<?php
/**
 * Created by PhpStorm.
 * User: resh
 * Date: 24.01.19
 * Time: 17:43
 */

namespace app\models;


use pheme\settings\models\BaseSetting;
use yii\base\InvalidParamException;
use yii\helpers\Json;

class Settings2 extends BaseSetting {

	public function setSetting($section, $key, $value, $type = null)
	{
		$model = static::findOne(['section' => $section, 'key' => $key]);

		if ($model === null) {
			$model = new static();
			$model->active = 1;
		}
		$model->section = $section;
		$model->key = $key;
		$model->value = strval($value);

		if ($type !== null) {
			$model->type = $type;
		} else {
			$t = gettype($value);
			if ($t == 'string') {
				$error = false;
				try {
					Json::decode($value);
				} catch (InvalidParamException $e) {
					$error = true;
				}
				if (!$error) {
					$t = 'string';
				}
			}
			$model->type = $t;
		}

		return $model->save();
	}

}