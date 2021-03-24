<?php

namespace app\models;

use mohorev\file\UploadImageBehavior;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Inflector;
use yii\validators\UniqueValidator;
use yii\imagine\Image;
use yii\rbac\ManagerInterface;

/**
 * This is the model class for table "news".
 *
 * @property integer $id
 * @property string $slug
 * @property string $title
 * @property string $text
 * @property string $name
 * @property string $keywords
 * @property string $description
 * @property integer $created_at
 * @property integer $updated_at
 */
class News extends \yii\db\ActiveRecord
{


    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className()
            ],
	        [
		        'class' => UploadImageBehavior::className(),
		        'attribute' => 'image',
		        'scenarios' => ['default'],
//                'placeholder' => '@app/modules/user/assets/images/userpic.jpg',
		        'path' => '@webroot/upload/news/{id}',
                //'path' => '@webroot/upload/news/{id}_domoptaru',
		        'url' => '@web/upload/news/{id}',
		        'thumbs' => [
			        'domoptaru_thumb' => ['width' => 500, 'height' => 350],
			        'domoptaru_preview' => ['width' => 200, 'height' => 200],
		        ],
	        ],
//            [
//                'class' => SluggableBehavior::className(),
//                'attribute' => 'title',
//                'slugAttribute' => 'slug',
//                'ensureUnique' => true,
//                ''
//            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'news';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['text', 'name'], 'required'],
            [['text'], 'string'],
            [['created_at', 'updated_at'], 'integer'],
            [['slug', 'name', 'title', 'keywords', 'description'], 'string', 'max' => 255],
	        ['image', 'image']
        ];
    }


    public function beforeSave($insert)
    {
        parent::beforeSave($insert);
        $this->validateSlug($insert);
        return true;
    }

    public function validateSlug($insert){
        $slug = $this->slug;
        if($slug == ''){
            $slug = '/news/' . Inflector::slug($this->title);
        }
        $iteration = 0;
        while($model = News::findOne(['slug' => $slug])){
            if($model->id == $this->id) break;
            $iteration++;
            $slug = '/news/' . Inflector::slug($this->title) . '-' . $iteration;
        }
        $this->slug = $slug;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'slug' => 'Ссылка',
            'name' => 'Название',
            'text' => 'Текст',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата изменения',
        ];
    }


    public function createThumb($path, $fname ,$prefix, $suffix, $width, $height){

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


    public function getThumbUploadUrl(){
        $path = '/upload/news/' . $this->id . '/domoptaru_thumb-' . $this->image;
        return $path;
    }

}
