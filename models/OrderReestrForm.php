<?php

/**
 * Created by PhpStorm.
 * User: resh
 * Date: 10.05.17
 * Time: 16:04
 */

namespace app\models;

use app\components\Helper;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;
use yii\web\UploadedFile;

class OrderReestrForm extends Model
{

    public $from;
    public $to;

    public function __construct()
    {
        $this->from = date("d.m.Y", time() - 3600 * 24 * 7);
        $this->to = date("d.m.Y");
    }

    public function rules()
    {
        return [
            [['from', 'to'], 'required'],
        ];
    }


    public function download($id)
    {
        return false;
    }
}
