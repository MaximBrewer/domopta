<?php

namespace app\migrations;

use yii\db\Migration;

class m170502_141812_users_field_active extends Migration
{
    public function up()
    {
        $this->addColumn('{{%user}}', 'is_active', $this->integer());
    }

    public function down()
    {
        echo "m170502_141812_users_field_active cannot be reverted.\n";

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
