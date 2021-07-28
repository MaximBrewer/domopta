<?php

namespace app\models;

use app\helpers\Inflector;

use mohorev\file\UploadImageBehavior;
use Yii;

/**
 * This is the model class for table "categories".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $name
 * @property string $slug
 * @property string $country
 * @property string $certificate
 * @property string $image
 * @property string $title
 * @property string $keywords
 * @property string $description
 * @property string $text
 * @property string $additional_text
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $rec_cat_id
 * @property integer $position
 * @property Products[] $products
 * @property Category $recCategory
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'categories';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'slug'], 'required'],
            [['parent_id', 'created_at', 'updated_at', 'rec_cat_id', 'position'], 'integer'],
            [['text', 'additional_text'], 'string'],
            [['name', 'slug', 'country', 'certificate', 'title', 'keywords', 'description'], 'string', 'max' => 255],
            ['image', 'image']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent ID',
            'name' => 'Название',
            'slug' => 'Ссылка',
            'country' => 'Страна',
            'certificate' => 'Сертификат',
            'image' => 'Изображение',
            'title' => 'Title',
            'keywords' => 'Keywords',
            'description' => 'Description',
            'text' => 'Текст',
            'additional_text' => 'Дополнительный текст',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'rec_cat_id' => 'Выбор категории для рекомендуемых товаров',
        ];
    }

    public function behaviors()
    {

        return [
            [
                'class' => UploadImageBehavior::class,
                'attribute' => 'image',
                'scenarios' => ['default'],
                //                'placeholder' => '@app/modules/user/assets/images/userpic.jpg',
                'path' => '@webroot/upload/category/{id}',
                'url' => '@web/upload/category/{id}',
                'thumbs' => [
                    'thumb' => ['width' => 276, 'height' => 171],
                    'preview' => ['width' => 200, 'height' => 200],
                ],
            ],
        ];
    }

    public function getChildren()
    {
        return Category::find()->where(['parent_id' => $this->id])->orderBy(['position' => SORT_ASC])->all();
    }

    private function getRecursiveChildren($parent, &$array)
    {
        $categories = Category::find()->where(['parent_id' => $this->id])->orderBy(['position' => SORT_ASC])->all();
        foreach ($categories as $category) {
            $array[] = $category->id;
        }
    }

    public function getAllChildrenIds()
    {
        $array = [$this->id];
        $this->getRecursiveChildren($this->id, $array);
        return $array;
    }

    public function getParent()
    {
        return $this->hasOne(Category::class, ['id' => 'parent_id']);
    }

    public function getParents()
    {
        $parents = [];
        if ($this->parent_id) {
            do {
                $parent = Category::findOne(['id' => $this->parent_id]);
                $parents[] = $parent;
            } while ($parent->parent_id);
        }
        return $parents;
    }

    public function getProducts()
    {
        $query = $this->hasMany(Products::class, ['category_id' => 'id']);

        return $query;
    }

    public function getRecCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'rec_cat_id']);
    }

    public function getNextproduct($article_index)
    {
        return Products::find()->andWhere(['category_id' => $this->id])
            ->andWhere(['>', 'article_index', $article_index])
            ->andWhere(['is_deleted' => 0])
            ->orderBy(['article_index' => SORT_ASC])
            ->one();
    }
    public function getPrevproduct($article_index)
    {
        return Products::find()->andWhere(['category_id' => $this->id])
            ->andWhere(['<', 'article_index', $article_index])
            ->andWhere(['is_deleted' => 0])
            ->orderBy(['article_index' => SORT_DESC])
            ->one();
    }

    public function getProductCount()
    {
        $categories = $this->getChildren();
        $cat_array[] = $this->id;
        foreach ($categories as $cat) {
            $cat_array[] = $cat->id;
        }
        $count = Products::find()->where(['category_id' => $cat_array, 'is_deleted' => 0])->count();
        return $count;
    }

    public function beforeSave($insert)
    {
        parent::beforeSave($insert);
        $this->validateSlug();
        if ($insert) {
            $this->rec_cat_id = 0;
        }
        return true;
    }

    public function validateSlug()
    {
        $slug = $this->slug;
        if ($slug == '') {
            $iteration = 0;
            do {
                $slug = '/category/' . Inflector::slug($this->name);
                $slug .= $iteration ? '-' . $iteration : '';
                $iteration++;
            } while (self::find()->where(['slug' => $slug])->andWhere(['!=', 'id', $this->id])->count());
        }
        $this->slug = $slug;
    }

    public function afterDelete()
    {
        foreach ($this->products as $product) {
            $product->is_deleted = 1;
            $product->save();
        }
        $models = $this->getChildren();
        foreach ($models as $model) {
            $model->delete();
        }
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        $seourl = SeoUrl::find()->where(['item_id' => $this->id])->andWhere(['route' => 'category'])->andWhere(['module' => 'catalog'])->one();
        if (!$seourl) {
            $seourl = new SeoUrl();
            $seourl->name = $this->name;
            $seourl->item_id = $this->id;
            $seourl->route = 'category';
            $seourl->module = 'catalog';
        }
        $seourl->slug = $this->slug;
        $seourl->save();
        $path = \Yii::getAlias('@webroot/upload/category/' . $this->id . '/*');
        $output = [];
        @exec("jpegoptim --all-progressive -ptm80 " . $path, $output);
    }
}
