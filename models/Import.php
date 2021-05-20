<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "cart".
 *
 */
class Import extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'imports';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [];
    }


    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class
            ],
        ];
    }
}
