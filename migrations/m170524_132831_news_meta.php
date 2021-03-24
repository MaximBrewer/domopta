<?php
namespace app\migrations;
use yii\db\Migration;

class m170524_132831_news_meta extends Migration
{
    public function up()
    {
        $this->addColumn('{{%news}}', 'name', $this->string());
        $this->addColumn('{{%news}}', 'keywords', $this->string());
        $this->addColumn('{{%news}}', 'description', $this->string());
    }

    public function down()
    {
        echo "m170524_132831_news_meta cannot be reverted.\n";

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
