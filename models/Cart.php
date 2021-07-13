<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "cart".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $article
 * @property string $color
 * @property integer $amount
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $product_id
 * @property Products $product
 * @property CartDetails $details
 */
class Cart extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cart';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'created_at', 'updated_at', 'product_id'], 'integer'],
            [['article'], 'string', 'max' => 255],
            ['memo', 'safe']
        ];
    }


    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className()
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'article' => 'Article',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getDetails()
    {
        return $this->hasMany(CartDetails::className(), ['cart_id' => 'id']);
    }
    

    public static function getAmount()
    {
        $items = Cart::findAll(['user_id' => Yii::$app->user->id]);
        $amount = 0;
        $sum = 0;
        foreach ($items as $item) {
            $product = Products::findOne(['article_index' => $item->article]);
            if (!$product) continue;
            $quantity = $product->pack_quantity ? $product->pack_quantity : 1;
            foreach ($item->details as $detail) {
                $amount += $quantity * $detail->amount;
                $sum += $product->getUserPrice() * $quantity * $detail->amount;
            }
        }
        return [
            'sum' => Products::formatPrice($sum),
            'amount' => $amount
        ];
    }

    public function getSum()
    {
        $sum = 0;
        $product = Products::findOne(['article_index' => $this->article]);
        if (!$product) return 0;
        $quantity = $product->pack_quantity ? $product->pack_quantity : 1;
        foreach ($this->details as $detail) {
            $sum += $this->price * $quantity * $detail->amount;
        }
        return $sum;
    }

    public function getRowSum()
    {
        $sum = 0;
        $product = Products::findOne(['article_index' => $this->article]);
        $quantity = $product->pack_quantity ? $product->pack_quantity : 1;
        foreach ($this->details as $detail) {
            $sum += $this->price * $quantity * $detail->amount;
        }
        return Yii::$app->formatter->asCurrency($sum, 'RUR');
    }

    public function getProduct()
    {
        return $this->hasOne(Products::className(), ['article_index' => 'article'])->where(['is_deleted' => 0]);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function afterDelete()
    {
        \Yii::$app->db->createCommand('DELETE FROM cart_details WHERE cart_id = :id')->bindValue(':id' ,$this->id)->execute();
        $user = User::findOne($this->user_id);
        $user->updateCartSum();
    }
}
