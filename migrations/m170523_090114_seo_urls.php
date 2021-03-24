<?php

namespace app\migrations;

use yii\db\Migration;

class m170523_090114_seo_urls extends Migration
{
    public function up()
    {
        $this->createTable('{{%seo_urls}}', [
            'id' => $this->primaryKey(),
            'slug' => $this->string()->unique(),
            'route' => $this->string(),
            'module' => $this->string(),
            'item_id' => $this->string(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer()
        ]);
    }

    public function down()
    {
        echo "m170508_121150_seo_urls cannot be reverted.\n";

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
