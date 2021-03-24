<?php

namespace app\components\fileinput;

use yii\jui\JuiAsset;
use yii\web\AssetBundle;

class FileInputAssets extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/fileinput.css',
    ];
    public $js = [
        'js/fileinput.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        JuiAsset::class
    ];
}