<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "products_backup".
 *
 * @property integer $id
 * @property string $name
 * @property string $article
 * @property string $article_index
 * @property string $color
 * @property string $size
 * @property string $consist
 * @property string $tradekmark
 * @property integer $pack_quantity
 * @property string $price
 * @property string $pack_price
 * @property integer $flag
 * @property integer $ooo
 * @property integer $category_id
 */
class ProductsBackup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'products_backup';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pack_quantity', 'flag', 'ooo', 'category_id', 'is_deleted', 'deleted_date'], 'integer'],
            [['price', 'pack_price', 'price2', 'pack_price'], 'number'],
            [['name', 'article', 'article_index', 'size', 'consist', 'tradekmark'], 'string', 'max' => 255],
            //['images', 'each', 'rule' => ['image']],
            ['description', 'safe'],
            ['slug', 'string'],
            ['color', 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'article' => 'Article',
            'article_index' => 'Article Index',
            'color' => 'Color',
            'size' => 'Size',
            'consist' => 'Consist',
            'tradekmark' => 'Tradekmark',
            'pack_quantity' => 'Pack Quantity',
            'price' => 'Price',
            'pack_price' => 'Pack Price',
            'flag' => 'Flag',
            'ooo' => 'Ooo',
            'category_id' => 'Category ID',
        ];
    }
}
