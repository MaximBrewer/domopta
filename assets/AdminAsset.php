<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\jui\JuiAsset;
use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AdminAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/admin.css',
    ];
    public $js = [
    ];
    public $depends = [
        'app\assets\AppAsset',
        'app\assets\BootboxAsset',
        JuiAsset::class,
    ];

    public function init()
    {
        \Yii::$app->view->registerJs('
            yii.confirm = function(message, ok, cancel) {
                bootbox.confirm({
                    message: message,
                    buttons: {
                        confirm: {
                            label: "Удалить",
                            className: "btn-success"
                        },
                        cancel: {
                            label: "Отмена",
                        }
                    },
                    callback: function(result) {
                        if (result) { !ok || ok(); } else { !cancel || cancel(); }
                    } 
                });
            }
        ');
    }

}
