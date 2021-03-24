<?php

namespace app\migrations;

use yii\db\Migration;

class m170510_093029_categories extends Migration
{
    public function up()
    {
        $this->createTable('{{%categories}}', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer(),
            'name' => $this->string(),
            'slug' => $this->string(),
            'country' => $this->string(),
            'certificate' => $this->string(),
            'image' => $this->string(),
            'title' => $this->string(),
            'keywords' => $this->string(),
            'description' => $this->string(),
            'text' => $this->text(),
            'additional_text' => $this->text(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer()
        ]);
    }

    public function down()
    {
        echo "m170510_093029_categories cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
