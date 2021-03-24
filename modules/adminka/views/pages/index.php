<?php
/**
 * @var $searchModel \app\models\PageSearch
 * @var $dataProvider \yii\data\ActiveDataProvider
 */

use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\helpers\Url;
use yii\helpers\Html;
?>
<?php echo Html::a('Добавить', ['/adminka/pages/add'], ['class' => 'btn btn-success']) ?>
<?php echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'class' => ActionColumn::className(),
            'template' => '{update} {delete}',
            'visibleButtons' => [
                'delete' => function ($model, $key, $index) {
                    return $model->module == 'pages';
                }
            ]
        ],
        'name',
        [
            'attribute' => 'slug',
            'value' => function($model){
                $url = $model->slug;
                return Html::a($url, $url, ['target' => '_blank']);
            },
            'format' => 'raw'
        ],
        'created_at:date'
    ]
]) ?>
