<?php
namespace app\migrations;

use yii\db\Migration;

class m181218_100017_page_contact extends Migration
{
    public function up()
    {
        $this->addColumn('{{%pages}}', 'menu_type', $this->integer()->defaultValue(0));
        $this->update('{{%pages}}', ['menu_type' => 1],['name' => 'Каталог']);
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
