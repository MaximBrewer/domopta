<?php
namespace app\migrations;

use yii\db\Migration;

class m170601_100017_page_contact extends Migration
{
    public function up()
    {
        $this->insert('{{%pages}}', [
            'name' => 'Написать администрации',
            'slug' => '/contact',
            'route' => '/site/contact',
            'module' => 'contact',
            'text' => '',
            'additional_text' => '',
            'title' => 'Написать администрации',
            'keywords' => '',
            'description' => '',
            'created_at' => 'NOW()',
            'updated_at' => 'NOW()'
        ]);
    }

    public function down()
    {
        echo "m170601_100017_page_contact cannot be reverted.\n";

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
