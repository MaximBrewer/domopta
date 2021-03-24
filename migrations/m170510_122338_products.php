<?php

namespace app\migrations;

use yii\db\Migration;

class m170510_122338_products extends Migration
{
    public function up()
    {
        $this->createTable('{{%products}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'article' => $this->string(),
            'article_index' => $this->string(),
            'color' => $this->string(),
            'size' => $this->string(),
            'consist' => $this->string(),
            'tradekmark' => $this->string(),
            'pack_quantity' => $this->integer(),
            'price' => $this->money(),
            'pack_price' => $this->money(),
            'flag' => $this->boolean(),
            'ooo' => $this->boolean(),
            'category_id' => $this->integer()
        ]);

        $this->createTable('{{%products_backup}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'article' => $this->string(),
            'article_index' => $this->string(),
            'color' => $this->string(),
            'size' => $this->string(),
            'consist' => $this->string(),
            'tradekmark' => $this->string(),
            'pack_quantity' => $this->integer(),
            'price' => $this->money(),
            'pack_price' => $this->money(),
            'flag' => $this->boolean(),
            'ooo' => $this->boolean(),
            'category_id' => $this->integer()
        ]);

        $this->createTable('{{%products_images}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer(),
            'image' => $this->string(),
            'order' => $this->integer()
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%products}}');
        $this->dropTable('{{%products_backup}}');
        $this->dropTable('{{%products_images}}');
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
