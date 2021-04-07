<?php

/**
 * @var $this \yii\web\View
 * @var $order \app\models\Order
 */

use app\models\Order;
use yii\widgets\DetailView;

echo DetailView::widget([
    'model' => $order,
    'attributes' => [
        'user.profile.lastname',
        'user.profile.name',
        'user.profile.surname',
        'user.profile.city',
        'user.profile.region',
        'user.profile.organization_name',
        [
            'attribute' => 'user.profile.phone',
            'format' => 'raw',
            'value' => function ($model) {
                return $model->user->profile->phone ? $model->user->profile->phone : '';
            }
        ],
        'user.email',
        'user.profile.inn',
        'fio',
        [
            'attribute' => 'phone',
            'format' => 'raw',
            'value' => function ($model) {
                return $model->phone ? $model->phone : '';
            }
        ],
        [
            'attribute' => 'passport_series',
            'format' => 'raw',
            'value' => function ($model) {
                return $model->passport_series ? $model->passport_series : '';
            }
        ],
        [
            'attribute' => 'passport_id',
            'format' => 'raw',
            'value' => function ($model) {
                return $model->passport_id ? $model->passport_id : '';
            }
        ],
        [
            'label' => 'Населенный пункт',
            'attribute' => 'locality',
            'format' => 'raw',
            'value' => function ($model) {
                return $model->locality ? $model->locality : '';
            }
        ],
        [
            'attribute' => 'delivery_method',
            'format' => 'raw',
            'value' => function ($model) {
                if ($model->delivery_method && isset(Order::$methods[$model->delivery_method]))
                    return Order::$methods[$model->delivery_method];
                else return '';
            }
        ],
        [
            'attribute' => 'tc',
            'format' => 'raw',
            'value' => function ($model) {
                if ($model->tc_name && $model->tc == 'other') return $model->tc_name;
                if ($model->tc && isset(Order::$tcs[$model->tc])) return Order::$tcs[$model->tc];
                return '';
            }
        ],
        [
            'label' => 'Город',
            'attribute' => 'locality',
            'format' => 'raw',
            'value' => function ($model) {
                return $model->city ? $model->city : '';
            }
        ],
        [
            'label' => 'Область',
            'attribute' => 'locality',
            'format' => 'raw',
            'value' => function ($model) {
                return $model->region ? $model->region : '';
            }
        ],
    ]
]);
