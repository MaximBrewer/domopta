<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "order_details".
 *
 * @property integer $id
 * @property integer $order_id
 * @property string $article
 * @property string $name
 * @property string $color
 * @property string $memo
 * @property integer $amount
 * @property string $price
 * @property string $price_old
 * @property string $sum
 * @property string $sum_old
 * @property integer $flag_old
 * @property integer $flag
 */
class OrderDetails extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order_details';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'amount'], 'integer'],
            [['price', 'price_old', 'sum', 'sum_old', 'flag', 'flag_old'], 'number'],
            [['article', 'name', 'color'], 'string', 'max' => 255],
            ['memo' , 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'Order ID',
            'article' => 'Артикул',
            'name' => 'Название',
            'color' => 'Цвет',
            'memo' => 'Примечание',
            'amount' => 'Колличество',
            'price' => 'Цена за ед.',
            'price_old' => 'Price Old',
            'sum' => 'Сумма',
            'sum_old' => 'Sum Old',
        ];
    }

    public function getProduct(){
        return $this->hasOne(Products::class, ['article_index' => 'article'])->where(['is_deleted' => 0]);
    }

}
