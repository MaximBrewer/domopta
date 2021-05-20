<?php

/**
 * Created by PhpStorm.
 * User: resh
 * Date: 25.01.19
 * Time: 16:00
 */

namespace app\modules\adminka\controllers;


use app\models\Cart;
use app\models\User;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use app\models\UserSearch;

class ImportsController extends Controller
{

    public function actionIndex()
    {
        $s = date(DATE_ATOM, strtotime("-1 months"));
        $f = date(DATE_ATOM);
        var_dump($s);
        var_dump($f);
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
