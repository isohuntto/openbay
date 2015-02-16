<?php

use yii\db\Schema;
use yii\db\Migration;

class m150122_064639_init extends Migration
{
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%comments}}', [
            'id' => Schema::TYPE_PK,
            'lft' => Schema::TYPE_INTEGER . ' NOT NULL',
            'rgt' => Schema::TYPE_INTEGER . ' NOT NULL',
            'depth' => Schema::TYPE_INTEGER . ' NOT NULL',
            'record_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'user_id' => Schema::TYPE_INTEGER . ' NULL DEFAULT NULL',
            'author' => Schema::TYPE_STRING . ' NOT NULL',
            'comment' => Schema::TYPE_TEXT . ' NOT NULL',
            'user_hash' => Schema::TYPE_STRING . '(32) NOT NULL',
            'rating' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL'
        ], $tableOptions);

        $this->createTable('{{%comment_marks}}', [
            'id' => Schema::TYPE_PK,
            'comment_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'user_id' => Schema::TYPE_INTEGER . ' NULL DEFAULT NULL',
            'user_hash' => Schema::TYPE_STRING . '(32) NOT NULL',
            'mark' => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 0',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);

        $this->createIndex('comments_record_id', '{{%comments}}', 'record_id');
        $this->createIndex('comments_user_hash', '{{%comments}}', 'user_hash');
        $this->createIndex('comments_user_id', '{{%comments}}', 'user_id');

        $this->createIndex('comment_marks_comment_id', '{{%comment_marks}}', 'comment_id');
        $this->createIndex('comment_marks_user_hash_id', '{{%comment_marks}}', 'user_hash');
        $this->createIndex('comment_marks_user_id', '{{%comment_marks}}', 'user_id');
        // Foreign Keys
        $this->addForeignKey('FK_comment_marks_comment_id', '{{%comment_marks}}', 'comment_id', '{{%comments}}', 'id', 'NO ACTION', 'NO ACTION');

        $this->insert('{{%comments}}', [
            'id' => 1,
            'lft' => 1,
            'rgt' => 2,
            'depth' => 0,
            'record_id' => 0,
            'author' => 'root',
            'comment' => 'root comment',
            'user_hash' => 'hash',
            'rating' => 0,
            'created_at' => 1422419131
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%comment_marks}}');
        $this->dropTable('{{%comments}}');
    }
}
