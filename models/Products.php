<?php

namespace app\models;

use Imagine\Image\ManipulatorInterface;
use Yii;
use app\helpers\Inflector;
use yii\imagine\Image;
use yii\rbac\ManagerInterface;
use yii\web\UploadedFile;

/**
 * This is the model class for table "products".
 *
 * @property integer $id
 * @property string $name
 * @property string $article
 * @property string $article_index
 * @property string $color
 * @property string $size
 * @property string $consist
 * @property string $tradekmark
 * @property string $slug
 * @property string $description
 * @property integer $pack_quantity
 * @property string $price
 * @property string $price2
 * @property string $pack_price
 * @property string $pack_price2
 * @property integer $flag
 * @property integer $ooo
 * @property integer $category_id
 * @property integer $is_deleted
 * @property ProductsImages[] $pictures
 */
class Products extends \yii\db\ActiveRecord
{

    public $images;

    public $hide = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'products';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pack_quantity', 'flag', 'ooo', 'category_id', 'is_deleted', 'deleted_date'], 'integer'],
            [['price', 'pack_price', 'price2', 'pack_price2'], 'number'],
            [['name', 'article', 'article_index', 'size', 'consist', 'tradekmark'], 'string', 'max' => 255],
            ['images', 'each', 'rule' => ['image']],
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
            'name' => 'Название',
            'article' => 'Артикул',
            'article_index' => 'Артикул / индекс',
            'color' => 'Цвета',
            'size' => 'Размеры',
            'consist' => 'Состав',
            'tradekmark' => 'Товарный знак',
            'pack_quantity' => 'Кол-во штук в упаковке',
            'price' => 'Цена Опт',
            'price2' => 'Мелкий опт',
            'pack_price' => 'Цена за упаковку',
            'pack_price2' => 'Цена за упаковку (мелкий опт)',
            'price_old' => 'Цена Опт (старая)',
            'price2_old' => 'Мелкий опт (старая)',
            'pack_price_old' => 'Цена за упаковку (старая)',
            'pack_price2_old' => 'Цена за упаковку (мелкий опт, старая)',
            'flag' => 'Остаток',
            'ooo' => 'Товар по ООО',
            'category_id' => 'Category ID',
            'description' => 'Описание',
            'slug' => 'Ссылка',
            'images' => 'Изображения'
        ];
    }

    public function getPictures()
    {
        return ProductsImages::find()
            ->where(['folder' => $this->folder, 'category_id' => $this->category_id])->orderBy('order')->all();
        // return $this->hasMany(ProductsImages::className(), ['product_id' => 'id'])->orderBy('order');
    }

    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    public function afterSave($insert, $changedAttributes)
    {
        if ($this->is_deleted == 1) {
            $carts = Cart::findAll(['article' => $this->article_index]);
            foreach ($carts as $cart) {
                $cart->delete();
            }

            foreach ($this->pictures as $image) {
                $image->delete();
            }
        }
    }

    public function createThumb($path, $fname, $prefix, $suffix, $width, $height)
    {
        $fnameArr = explode(".", $fname);
        $ext = $fnameArr[count($fnameArr) - 1];
        unset($fnameArr[count($fnameArr) - 1]);
        $fnameClean = implode(".", $fnameArr);

        $image = Image::getImagine()->open($path . $fname);
        $ratio = $image->getSize()->getWidth() / $image->getSize()->getHeight();
        if ($width) {
            $height = ceil($width / $ratio);
        } else {
            $width = ceil($height * $ratio);
        }

        ini_set('memory_limit', '512M');
        Image::thumbnail($path . $fname, $width, $height, ManipulatorInterface::THUMBNAIL_INSET)
            ->save($path . $prefix . $fnameClean . $suffix . "." . $ext, ['quality' => 100]);
    }

    public function beforeSave($insert)
    {
        parent::beforeSave($insert);
        $this->folder = Inflector::slug($this->article_index);
        $this->validateSlug($insert);
        $this->color = str_replace(', ', ',', $this->color);
        return true;
    }

    public function validateSlug($insert)
    {
        $slug = $this->slug;
        if (!$slug) {
            $slug = $this->generateSlugForInport($this->article_index);
            // $iteration = 0;
            // do {
            //     $slug = $iteration ? $iteration . '-' : "";
            //     $slug .= Inflector::slug($this->name) . '-' . Inflector::slug($this->article);
            //     $model = Products::find()->where(['slug' => $slug])->andWhere(['<>', 'id', $this->id])->one();
            //     $iteration++;
            // } while ($model);
        }
        $this->slug = $slug;
    }

    public function generateSlugForInport($article_index = false)
    {
        if ($article_index)
            $slug = Yii::$app->db->createCommand('SELECT slug FROM slugs WHERE article=:article')
                ->bindValues([':article' => $article_index])
                ->queryOne();
        if ($slug) {
            return $slug['slug'];
        } else {
            $iteration = 0;
            do {
                $slug = $iteration ? $iteration . '-' : "";
                $slug .= Inflector::slug($this->name) . '-' . Inflector::slug($this->article);
                $model = Products::find()->where(['slug' => $slug])->andWhere(['<>', 'id', $this->id])->one();
                $iteration++;
            } while ($model);
            \Yii::$app->db->createCommand('INSERT INTO slugs  (`article`, `slug`) VALUES (:article, :slug)')->bindValues([':article' => $article_index, ':slug' => $this->category->slug . "/" . $slug])->execute();
            return $this->category->slug . "/" . $slug;
        }
    }

    public function afterDelete()
    {
        $carts = Cart::findAll(['id' => $this->id]);
        $cart_i = 0;
        foreach ($carts as $cart) {
            $cart->delete();
            $cart_i++;
        }
        Yii::$app->session->addFlash('success1', 'Из корзин: ' . $cart_i);

        $models = ProductsImages::findAll(['folder' => $this->folder, 'category_id' => $this->category_id]);
        foreach ($models as $model) {
            $model->delete();
        }
        $path = Yii::getAlias('@webroot/upload/product/' . $this->folder . '/');
        @rmdir($path);

        $fav = Favorite::findAll(['product_id' => $this->id]);
        $fav_i = 0;
        foreach ($fav as $item) {
            $fav_i++;
            $item->delete();
        }
        Yii::$app->session->addFlash('success2', 'Из закладок: ' . $fav_i);

        $product_views = ProductViews::findAll(['product_id' => $this->id]);
        foreach ($product_views as $product_view) {
            $product_view->delete();
        }
    }

    public static function find()
    {
        $query = parent::find();
        if (!Yii::$app->user->isGuest && !Yii::$app->user->identity->getIsAdmin()) {
            if (Yii::$app->user->identity->flags == 1) {
                $query->andWhere(['ooo' => '1']);
            }
        }
        return $query;
    }

    public function afterFind()
    {
        $this->price = number_format($this->price, 2, '.', '');
        $this->price2 = number_format($this->price2, 2, '.', '');
        $this->color = str_replace(',', ', ', $this->color);
    }


    public function getNextproduct()
    {
        $product = Products::find()
            ->where(['>', 'article', $this->article])
            ->andWhere(['is_deleted' => 0])
            ->andWhere(['category_id' => $this->category_id])
            ->orderBy(['article' => SORT_ASC])
            ->one();
        if (!$product) {
            return false;
        }
        return $product;
    }
    public function getPrevproduct()
    {
        $product = Products::find()->where(['<', 'article', $this->article])
            ->andWhere(['is_deleted' => 0])
            ->andWhere(['category_id' => $this->category_id])
            ->orderBy(['article' => SORT_DESC])
            ->one();
        if (!$product) {
            return false;
        }
        return $product;
    }


    public function hasColor($color)
    {
        foreach (explode(',', $this->color) as $clr) {
            if (trim($color) == trim($clr)) return true;
        }
        return false;
    }

    public function getUserPrice($getAttr = false)
    {
        if (Yii::$app->user->identity->profile->type == 1 || Yii::$app->user->identity->profile->type == 3) {
            return $getAttr ? 'price' : $this->price;
        } else {
            return $getAttr ? 'price2' : $this->price2;
        }
    }

    public static function formatPrice($model, $priceArr = [], $callback = null)
    {
        if (!is_object($model)) {
            $price = $model;
            $oldPrice = $price;
        } elseif ($callback) {
            $attr = $model->{$callback}(true);
            $price = $model->{$attr};
            $oldPrice = $model->{$attr . "_old"};
        } else {
            foreach ($priceArr as $attr) {
                if ($model->{$attr}) {
                    $oldPrice = $model->{$attr . "_old"};
                    $price = $model->{$attr};
                    break;
                }
            }
        }
        if (ceil($price * 100) == intVal(ceil($price) . '00')) {
            return ($oldPrice > $price ? '<span class="old">' . number_format($oldPrice, 0, '', '') . '</span><span>' . number_format($price, 0, '', '') . '</span>' : number_format($price, 0, '', ''));
        } else {
            return ($oldPrice > $price ? '<span class="old">' . number_format($oldPrice, 2, ',<span class="kopeyki">', '') . '</span></span><span>' . number_format($price, 2, ',<span class="kopeyki">', '') . '</span></span>' : number_format($price, 2, ',<span class="kopeyki">', '') . '</span>');
        }
    }

    public static function formatEmailPrice($price, $cur = false)
    {
        if ($price) {
            if (ceil($price * 100) == intVal(ceil($price) . '00')) {
                $return = number_format($price, 0, ',', " ");
                if ($cur) $return .= ' руб.';
            } else {
                $return = number_format($price, 2, ',', " ");
                if ($cur) $return .= ' руб.';
            }
        } else
            return '';
        return str_replace(' ', '&nbsp;', $return);
    }

    public static function formatEmailItog($price, $cur = false)
    {
        if (!$price) {
            $return = '0 руб.';
        } elseif (ceil($price * 100) == intVal(ceil($price) . '00')) {
            $return = number_format($price, 0, ',', " ");
            if ($cur) $return .= ' руб.';
        } else {
            $return = number_format($price, 2, ',', " ");
            if ($cur) $return .= ' руб.';
        }
        return str_replace(' ', '&nbsp;', $return);
    }
}
