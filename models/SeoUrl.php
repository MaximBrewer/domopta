<?php

namespace app\models;

use Yii;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "pages".
 *
 * @property integer $id
 * @property string $title
 * @property string $name
 * @property string $slug
 * @property string $route
 * @property string $module
 * @property string $text
 * @property string $additional_text
 * @property string $keywords
 * @property string $description
 * @property integer $created_at
 * @property integer $updated_at
 */
class SeoUrl extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */

    public $keywords;
    public $description;
    public $title;

    public static function tableName()
    {
        return 'seo_urls';
    }

    public function behaviors()
    {
        return [
            [
                'class' => SluggableBehavior::className(),
                'attribute' => 'name',
                'slugAttribute' => 'slug',
            ],
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'slug'], 'required'],
            [['slug'], 'unique'],
            [['slug', 'route', 'module', 'name'], 'string', 'max' => 255],
            [['created_at', 'updated_at'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'slug' => 'Ссылка',
            'route' => 'Route',
            'module' => 'Module',
            'item_id' => 'Description',
            'created_at' => 'Дата публикации',
            'updated_at' => 'Updated At'
        ];
    }

    public function beforeValidate()
    {
        if (false === strpos($this->slug, '/')) {
            $this->slug = '/' . $this->slug;
        }
        return true;
    }
}
