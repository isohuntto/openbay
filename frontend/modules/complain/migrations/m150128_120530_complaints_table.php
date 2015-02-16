<?php

use yii\db\Schema;
use yii\db\Migration;

class m150128_120530_complaints_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%complaints}}', [
            'id' => Schema::TYPE_PK,
            'record_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'user_id' => Schema::TYPE_INTEGER . ' NULL DEFAULT NULL',
            'type' => Schema::TYPE_INTEGER . ' NOT NULL',
            'user_hash' => Schema::TYPE_STRING . '(32) NOT NULL',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL'
        ], $tableOptions);

        $this->createIndex('complaints_record_id', '{{%complaints}}', 'record_id');
        $this->createIndex('complaints_user_hash', '{{%complaints}}', 'user_hash');
        $this->createIndex('complaints_user_id', '{{%complaints}}', 'user_id');
    }

    public function safeDown()
    {
        $this->dropTable('{{%complaints}}');
    }
}
