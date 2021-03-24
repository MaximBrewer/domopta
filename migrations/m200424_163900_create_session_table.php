<?php

namespace app\migrations;

use yii\db\Migration;
/**
 * Handles the creation of table `{{%session}}`.
 */
class m200424_163900_create_session_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%session}}', [
            'id' => $this->primaryKey(),
            'data' => $this->binary(429496729),
            'expire' => $this->integer(),
            'user_id' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%session}}');
    }
}
