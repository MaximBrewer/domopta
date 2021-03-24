<?php
namespace app\migrations;

use yii\db\Migration;

class m170518_130220_memo extends Migration
{
    public function up()
    {
        $this->dropColumn('{{%cart_details}}', 'memo');
        $this->addColumn('{{%cart}}', 'memo', $this->string());
    }

    public function down()
    {
        echo "m170518_130220_memo cannot be reverted.\n";

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
