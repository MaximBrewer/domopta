<?php

namespace app\migrations;

use yii\db\Migration;

class m170513_111032_cart extends Migration
{
    public function up()
    {
        $this->createTable('{{%cart}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'article' => $this->string(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer()
        ]);

        $this->createTable('{{%cart_details}}', [
            'id' => $this->primaryKey(),
            'cart_id' => $this->integer(),
            'color' => $this->string(),
            'amount' => $this->integer(),
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%cart}}');
        $this->dropTable('{{%cart_details}}');
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
