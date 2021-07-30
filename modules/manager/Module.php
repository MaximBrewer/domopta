<?php

/**
 * Created by PhpStorm.
 * User: resh
 * Date: 02.05.17
 * Time: 16:49
 */

namespace app\modules\manager;


use dektrium\user\filters\AccessRule;
use yii\filters\AccessControl;

class Module extends \yii\base\Module
{

    public function __construct($id, $parent = null, $config = [])
    {
        defined('MODULE_ID') or define('MODULE_ID', 'manager12');
        parent::__construct($id, $parent, $config);
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'ruleConfig' => [
                    'class' => AccessRule::class,
                ],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin', 'moderator', 'manager', 'contentmanager'],
                    ]
                ],
            ],
        ];
    }

    public function init()
    {
        parent::init();
        $this->layout = '@app/views/layouts/manager';
    }
}
