<?php

/**
 * Created by PhpStorm.
 * User: resh
 * Date: 13.05.17
 * Time: 14:31
 */

namespace app\models;

use yii\base\Model;

class ProductForm extends Model
{
    public $product_id;
    public $colors;

    public function rules()
    {
        return [
            ['product_id', 'exist', 'targetClass' => Products::class, 'targetAttribute' => 'id'],
            ['colors', 'each', 'rule' => ['integer', 'min' => 1, 'skipOnEmpty' => true]]
        ];
    }

    public function addToCart()
    {
        $product = Products::findOne($this->product_id);
        $cart = Cart::findOne([
            'article' => $product->article_index,
            'user_id' => \Yii::$app->user->id,
        ]);

        if (!$cart) {
            $cart = new Cart();
            $cart->article = $product->article_index;
            $cart->user_id = \Yii::$app->user->id;
        }
        
        $cart->price = \Yii::$app->user->identity->profile->type == 2 ? $product->price2 : $product->price;
        $cart->product_id = $product->id;
        $cart->save();

        foreach ($this->colors as $color => $amount) {
            if (!$amount) continue;
            $details = CartDetails::findOne([
                'cart_id' => $cart->id,
                'color' => $color
            ]);
            if (!$details) {
                $details = new CartDetails();
            }

            $details->cart_id = $cart->id;
            $details->color = $color;
            $details->amount += $amount;
            $details->save();
        }
    }
}
