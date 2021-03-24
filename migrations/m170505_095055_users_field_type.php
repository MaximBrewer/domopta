<?php
namespace app\migrations;

use yii\db\Migration;

class m170505_095055_users_field_type extends Migration
{
    public function up()
    {
        $this->alterColumn('{{%profile}}', 'type', $this->string());
    }

    public function down()
    {
        echo "m170505_095055_users_field_type cannot be reverted.\n";

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
