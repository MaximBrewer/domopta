<?php

namespace app\migrations;

use yii\db\Migration;

class m170515_083808_cart_memo extends Migration
{
    public function up()
    {
        $this->addColumn('{{%cart_details}}', 'memo', $this->string());
    }

    public function down()
    {
        $this->dropColumn('{{%cart_details}}', 'memo');
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
