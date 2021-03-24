<?php

namespace app\migrations;

use yii\db\Migration;

class m170512_071630_page_menu extends Migration
{
    public function up()
    {
        $this->addColumn('{{%pages}}', 'status', $this->boolean()->defaultValue(1));

        $this->createTable('{{%menu}}', [
            'id' => $this->primaryKey(),
            'page_id' => $this->integer(),
            'order' => $this->integer(),
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%menu}}');
        $this->dropColumn('{{%pages}}', 'status');
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
