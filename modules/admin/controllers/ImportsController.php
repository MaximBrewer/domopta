<?php

/**
 * Created by PhpStorm.
 * User: resh
 * Date: 25.01.19
 * Time: 16:00
 */

namespace app\modules\admin\controllers;


use app\models\Cart;
use app\models\User;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use app\models\UserSearch;

class ImportsController extends Controller
{

    public function actionIndex()
    {
        $s = date("Y-m-d H:i:s", strtotime("-1 months"));
        $f = date("Y-m-d H:i:s");
        $dataProvider = new ActiveDataProvider([
            'query' => User::find()
                ->select('user.*, (SELECT COUNT(*) FROM imports WHERE imports.user_id=user.id AND datetime BETWEEN \''.$s.'\' AND \''.$f.'\') as imports')
                ->where('(SELECT COUNT(*) FROM imports WHERE imports.user_id=user.id AND datetime BETWEEN \''.$s.'\' AND \''.$f.'\') > 0')
                ->orderBy(['imports' => SORT_DESC])
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }
}
