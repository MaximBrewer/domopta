<?php

namespace  app\migrations;

use yii\db\Migration;

class m170515_075254_order extends Migration
{
    public function up()
    {
        $this->createTable('{{%order}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'created_at' => $this->integer(),
        ]);

        $this->createTable('{{%order_details}}',[
            'id' => $this->primaryKey(),
            'order_id' => $this->integer(),
            'article' => $this->string(),
            'name' => $this->string(),
            'color' => $this->string(),
            'memo' => $this->string(),
            'amount' => $this->integer(),
            'price' => $this->money(),
            'price_old' => $this->money(),
            'sum' => $this->money(),
            'sum_old' => $this->money()
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%order}}');
        $this->dropTable('{{%order_details}}');
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
