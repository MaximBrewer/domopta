<?php

namespace app\migrations;

use yii\db\Migration;

class m170517_102623_pages extends Migration
{
    public function up()
    {
        $this->insert('{{%pages}}', [
            'name' => 'Корзина',
            'slug' => '/cart',
            'route' => '/cart/index',
            'module' => 'cart',
            'text' => '',
            'additional_text' => '',
            'title' => 'Корзина',
            'keywords' => '',
            'description' => '',
            'created_at' => 'NOW()',
            'updated_at' => 'NOW()'
        ]);
        $this->insert('{{%pages}}', [
            'name' => 'Забыл пароль',
            'slug' => '/forgot',
            'route' => '/user/recovery/request',
            'module' => 'user',
            'text' => '',
            'additional_text' => '',
            'title' => 'Забыл пароль',
            'keywords' => '',
            'description' => '',
            'created_at' => 'NOW()',
            'updated_at' => 'NOW()'
        ]);
    }

    public function down()
    {
        echo "m170517_102623_pages cannot be reverted.\n";

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
