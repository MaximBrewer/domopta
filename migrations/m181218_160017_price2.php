<?php
namespace app\migrations;

use yii\db\Migration;

class m181218_160017_price2 extends Migration
{
    public function up()
    {
        $this->addColumn('{{%products}}', 'price2', $this->money());
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
