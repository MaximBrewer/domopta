<?php

namespace app\migrations;

use yii\db\Migration;

class m170512_132602_product_change extends Migration
{
    public function up()
    {
        $this->addColumn('{{%products}}', 'description', $this->text());
        $this->addColumn('{{%products}}', 'slug', $this->string());

        $this->addColumn('{{%products_backup}}', 'description', $this->text());
        $this->addColumn('{{%products_backup}}', 'slug', $this->string());
    }

    public function down()
    {
        echo "m170512_132602_product_change cannot be reverted.\n";

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
