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
class Page extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pages';
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
            [['text', 'additional_text'], 'string'],
            [['created_at', 'updated_at', 'status'], 'integer'],
            [['title', 'slug', 'route', 'module', 'name'], 'string', 'max' => 255],
            [['keywords', 'description'], 'string', 'max' => 512],
            ['status', 'default', 'value' => 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'name' => 'Название',
            'slug' => 'Ссылка',
            'route' => 'Route',
            'module' => 'Module',
            'text' => 'Текст',
            'additional_text' => 'Дополнительный текст',
            'keywords' => 'Keywords',
            'description' => 'Description',
            'created_at' => 'Дата публикации',
            'updated_at' => 'Updated At',
            'status' => 'Отображать на сайте',
        ];
    }

    public function beforeValidate()
    {
        if($this->route == ''){
            $this->route = '/pages/index';
            $this->module = 'pages';
        }
        if(false === strpos($this->slug, '/')){
            $this->slug = '/' . $this->slug;
        }
        return true;
    }


}