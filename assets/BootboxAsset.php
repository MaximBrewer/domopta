<?php
namespace app\assets;

use Yii;
use yii\web\AssetBundle;

class BootboxAsset extends AssetBundle
{
    public $sourcePath = '@vendor/bower-asset/bootbox';
    public $js = [
        'bootbox.js',
    ];
}