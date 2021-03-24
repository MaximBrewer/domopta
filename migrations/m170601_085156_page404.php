<?php

namespace app\migrations;

use yii\db\Migration;
class m170601_085156_page404 extends Migration
{
    public function up()
    {
        $this->insert('{{%pages}}', [
            'name' => '404',
            'slug' => '/404',
            'route' => '/site/error',
            'module' => 'error',
            'text' => '',
            'additional_text' => '',
            'title' => 'error',
            'keywords' => '',
            'description' => '',
            'created_at' => 'NOW()',
            'updated_at' => 'NOW()'
        ]);
    }

    public function down()
    {
        echo "m170601_085156_page404 cannot be reverted.\n";

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
