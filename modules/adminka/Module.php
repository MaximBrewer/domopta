<?php
/**
 * Created by PhpStorm.
 * User: resh
 * Date: 02.05.17
 * Time: 16:49
 */

namespace app\modules\adminka;


use dektrium\user\filters\AccessRule;
use yii\filters\AccessControl;

class Module extends \yii\base\Module
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'ruleConfig' => [
                    'class' => AccessRule::className(),
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
        $this->layout = '@app/views/layouts/admin';
    }

}