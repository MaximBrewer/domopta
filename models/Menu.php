<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "menu".
 *
 * @property integer $id
 * @property integer $page_id
 * @property integer $order
 */
class Menu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['page_id', 'required'],
            [['page_id', 'order'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'page_id' => 'Страница',
            'order' => 'Порядок отображения',
        ];
    }

    public function getPage(){
        return $this->hasOne(Page::className(), ['id' => 'page_id']);
    }
}
