<?php
/**
 * Created by PhpStorm.
 * User: resh
 * Date: 03.05.17
 * Time: 11:42
 */

namespace app\models;

use yii\base\Model;

class BlockForm extends Model
{

    public $text;
    public $id;

    public function rules()
    {
        return [
            ['text', 'required'],
            ['id', 'required']
        ];
    }

    public function block($user){
        $user->profile->admins_comment = $this->text;
        $user->profile->save();
        $user->block();
    }

    public function attributeLabels()
    {
        return [
            'text' => 'Причина блокировки'
        ];
    }

}