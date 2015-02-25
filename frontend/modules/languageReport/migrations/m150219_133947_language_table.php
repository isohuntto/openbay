<?php

use yii\db\Schema;
use yii\db\Migration;

class m150219_133947_language_table extends Migration {

    public function up() {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%language}}', [
            'id' => Schema::TYPE_PK,
            'language' => Schema::TYPE_STRING . " NOT NULL",
            'confirmed' => Schema::TYPE_INTEGER . " NOT NULL DEFAULT 1",
        ], $tableOptions);
        $this->createIndex('language_unique_language', '{{%language}}', 'language', true);
    }

    public function down() {
        $this->dropTable('{{%language}}');
    }

}
