<?php

use yii\db\Schema;
use yii\db\Migration;

class m150127_051206_rating_table extends Migration
{
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%ratings}}', [
            'id' => Schema::TYPE_PK,
            'record_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'user_id' => Schema::TYPE_INTEGER . ' DEFAULT NULL',
            'user_hash' => Schema::TYPE_STRING . '(32) NOT NULL',
            'rating' => Schema::TYPE_SMALLINT . ' NOT NULL',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);

        $this->createIndex("ratings_record_id", "{{%ratings}}", ['record_id']);
        $this->createIndex("ratings_user_id", "{{%ratings}}", ['user_id']);
        $this->createIndex("ratings_user_hash", "{{%ratings}}", ['user_hash']);
    }

    public function down()
    {
        $this->dropTable('{{%ratings}}');
    }
}
