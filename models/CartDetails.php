<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cart_details".
 *
 * @property integer $id
 * @property string $color
 * @property integer $amount
 * @property integer $cart_id
 * @property Cart $cart
 */
class CartDetails extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cart_details';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['amount', 'cart_id'], 'integer'],
            [['color'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'color' => 'Color',
            'amount' => 'Amount',
        ];
    }

    public function getCart(){
        return $this->hasOne(Cart::className(), ['id' => 'cart_id']);
    }

    public function getSum(){
        $quantity = $this->cart->product->pack_quantity?$this->cart->product->pack_quantity:1;
        return $this->amount * $quantity * $this->cart->product->price;
    }

    public function getPrice(){
        $quantity = $this->cart->product->pack_quantity?$this->cart->product->pack_quantity:1;
        return $quantity * $this->cart->product->price;
    }

}
