<?php
namespace app\migrations;

use yii\db\Migration;


class m170508_125543_pages_list extends Migration
{
    public function up()
    {
        $this->insert('{{%pages}}', [
            'name' => 'Главная',
            'slug' => '/',
            'route' => '/site/index',
            'module' => 'main',
            'text' => '',
            'additional_text' => '',
            'title' => 'Главная',
            'keywords' => '',
            'description' => '',
            'created_at' => 'NOW()',
            'updated_at' => 'NOW()'
        ]);
        $this->insert('{{%pages}}', [
            'name' => 'Вход',
            'slug' => '/signin',
            'route' => '/user/security/login',
            'module' => 'user',
            'text' => '',
            'additional_text' => '',
            'title' => 'Вход',
            'keywords' => '',
            'description' => '',
            'created_at' => 'NOW()',
            'updated_at' => 'NOW()'
        ]);
        $this->insert('{{%pages}}', [
            'name' => 'Регистрация',
            'slug' => '/signup',
            'route' => '/user/registration/register',
            'module' => 'user',
            'text' => '',
            'additional_text' => '',
            'title' => 'Регистрация',
            'keywords' => '',
            'description' => '',
            'created_at' => 'NOW()',
            'updated_at' => 'NOW()'
        ]);
    }

    public function down()
    {
        echo "m170508_125543_pages_list cannot be reverted.\n";

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
