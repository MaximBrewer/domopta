<?php
namespace app\migrations;

use yii\db\Migration;

class m170503_095239_users_field_ignore extends Migration
{
    public function up()
    {
        $this->addColumn('{{%user}}', 'is_ignored', $this->integer());
    }

    public function down()
    {
        echo "m170503_095239_users_field_ignore cannot be reverted.\n";

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
