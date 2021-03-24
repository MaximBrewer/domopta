<?php
namespace app\migrations;

use yii\db\Migration;

class m181219_160017_confirm_code extends Migration
{
    public function up()
    {
        $this->addColumn('{{%user}}', 'phone_code', $this->string());
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
