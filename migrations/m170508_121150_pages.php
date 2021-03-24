<?php
namespace app\migrations;

use yii\db\Migration;


class m170508_121150_pages extends Migration
{
    public function up()
    {
        $this->createTable('{{%pages}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'slug' => $this->string()->unique(),
            'route' => $this->string(),
            'module' => $this->string(),
            'text' => $this->text(),
            'additional_text' => $this->text(),
            'title' => $this->string(),
            'keywords' => $this->string(512),
            'description' => $this->string(512),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer()
        ]);
    }

    public function down()
    {
        echo "m170508_121150_pages cannot be reverted.\n";

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
