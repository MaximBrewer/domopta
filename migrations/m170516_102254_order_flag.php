<?php

namespace app\migrations;

use yii\db\Migration;

class m170516_102254_order_flag extends Migration
{
    public function up()
    {
        $this->addColumn('{{%order_details}}', 'flag', $this->integer());
        $this->addColumn('{{%order_details}}', 'flag_old', $this->integer());
    }

    public function down()
    {
        echo "m170516_102254_order_flag cannot be reverted.\n";

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
