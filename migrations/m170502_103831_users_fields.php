<?php

namespace app\migrations;

use yii\db\Migration;

class m170502_103831_users_fields extends Migration
{
    public function up()
    {
        $this->addColumn('{{%user}}', 'role', $this->string());
        $this->addColumn('{{%user}}', 'not_delete', $this->integer());
        $this->addColumn('{{%profile}}', 'surname', $this->string());
        $this->addColumn('{{%profile}}', 'lastname', $this->string());
        $this->addColumn('{{%profile}}', 'city', $this->string());
        $this->addColumn('{{%profile}}', 'region', $this->string());
        $this->addColumn('{{%profile}}', 'organization_name', $this->string());
        $this->addColumn('{{%profile}}', 'phone', $this->string());
        $this->addColumn('{{%profile}}', 'inn', $this->string());
        $this->addColumn('{{%profile}}', 'users_comment', $this->string());
        $this->addColumn('{{%profile}}', 'admins_comment', $this->string());
        $this->addColumn('{{%profile}}', 'order_comment', $this->string());
        $this->addColumn('{{%profile}}', 'type', $this->integer());
        $this->addColumn('{{%profile}}', 'demo', $this->integer());
        $this->addColumn('{{%profile}}', 'suspicious', $this->integer());
    }

    public function down()
    {
        echo "m170502_103831_users_fields cannot be reverted.\n";

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
