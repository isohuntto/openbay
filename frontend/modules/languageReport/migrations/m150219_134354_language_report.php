<?php

use yii\db\Schema;
use yii\db\Migration;

class m150219_134354_language_report extends Migration {

    public function safeUp() {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%language_report}}', [
            'id' => Schema::TYPE_PK,
            'record_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'user_id' => Schema::TYPE_INTEGER . ' NULL DEFAULT NULL',
            'language' => Schema::TYPE_STRING . ' NOT NULL',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);

        $this->createIndex('language_report_record_id', '{{%language_report}}', 'record_id');
        $this->createIndex('language_report_user_id', '{{%language_report}}', 'user_id');
    }

    public function safeDown() {
        $this->dropTable('{{%language_report}}');
    }

}
