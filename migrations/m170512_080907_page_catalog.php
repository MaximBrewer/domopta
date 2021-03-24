<?php

namespace app\migrations;

use yii\db\Migration;

class m170512_080907_page_catalog extends Migration
{
    public function up()
    {
        $this->insert('{{%pages}}', [
            'name' => 'Каталог',
            'slug' => '/catalog',
            'route' => '/catalog/index',
            'module' => 'catalog',
            'text' => '',
            'additional_text' => '',
            'title' => 'Каталог',
            'keywords' => '',
            'description' => '',
            'created_at' => 'NOW()',
            'updated_at' => 'NOW()'
        ]);
    }

    public function down()
    {
        echo "m170512_080907_page_catalog cannot be reverted.\n";

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
