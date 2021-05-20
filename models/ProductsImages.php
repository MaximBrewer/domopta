<?php

namespace app\models;

use app\helpers\Inflector;

use Yii;

/**
 * This is the model class for table "products_images".
 *
 * @property integer $id
 * @property string $image
 * @property integer $order
 */
class ProductsImages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'products_images';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order', 'category_id'], 'integer'],
            [['folder', 'image'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'folder' => 'Product Article Index',
            'image' => 'Image',
            'order' => 'Order',
        ];
    }

    public function getUrl($prefix = 'thumb', $num = 0)
    {
        $fnameArr = explode(".", $this->image);
        $ext = $fnameArr[count($fnameArr) - 1];
        unset($fnameArr[count($fnameArr) - 1]);
        $fnameClean = implode(".", $fnameArr);

        $suffix = '-domopta.ru';

        $path = __DIR__ . '/../web' . '/upload/product/' . $this->folder . '/' . $prefix . "-" . $fnameClean . $suffix . "." . $ext;

        if (file_exists($path)) {
            return '/upload/product/' . $this->folder . '/' . $prefix . "-" . $fnameClean . $suffix . "." . $ext;
        } else {
            return '/upload/product/' . $this->folder . '/' . $prefix . '-' . $this->image;
        }
    }

    public function afterDelete()
    {
        $path = Yii::getAlias('@webroot/upload/product/' . $this->folder . '/');
        @unlink($path . $this->image);
        @unlink(Yii::getAlias('@webroot' . $this->getUrl('big')));
        @unlink(Yii::getAlias('@webroot' . $this->getUrl('small')));
        @unlink(Yii::getAlias('@webroot' . $this->getUrl('thumb')));
    }
}
