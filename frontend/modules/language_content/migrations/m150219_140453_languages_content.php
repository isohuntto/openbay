<?php

use yii\db\Schema;
use yii\db\Migration;

class m150219_140453_languages_content extends Migration
{
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%languages_content}}', [
            'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'model_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'language_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'created_at' => Schema::TYPE_INTEGER. ' NOT NULL',
        ], $tableOptions);

        $this->createIndex('languages_content_user_id', '{{%languages_content}}', 'user_id');
        $this->createIndex('languages_content_language_id', '{{%languages_content}}', 'language_id');
        $this->addPrimaryKey('pk_languages_content', '{{%languages_content}}', ['user_id', 'model_id', 'language_id']);
        $this->addForeignKey(
            'fk_languages_content_language_id',
            '{{%languages_content}}',
            'language_id',
            '{{%languages}}',
            'id'
        );
        $this->addForeignKey(
            'fk_languages_content_user_id',
            '{{%languages_content}}',
            'user_id',
            '{{%user}}',
            'id'
        );
    }

    public function safeDown()
    {
        $this->dropTable('{{%languages_content}}');
    }
}
