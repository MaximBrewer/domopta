<?php

namespace app\migrations;

use yii\db\Migration;

class m170523_090114_pages extends Migration
{
    public function up()
    {
        $this->insert('{{%pages}}', [
            'name' => 'Новости',
            'slug' => '/news',
            'route' => '/news/index',
            'module' => 'catalog',
            'text' => '',
            'additional_text' => '',
            'title' => 'Новости',
            'keywords' => '',
            'description' => '',
            'created_at' => 'NOW()',
            'updated_at' => 'NOW()'
        ]);
    }

    public function down()
    {
        echo "m170523_090114_pages cannot be reverted.\n";

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
