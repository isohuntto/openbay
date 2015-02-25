<?php

use yii\db\Schema;
use yii\db\Migration;

class m150219_223825_torrent_language extends Migration {

    public function safeUp() {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%torrent_language}}', [
            'id' => Schema::TYPE_INTEGER . ' NOT NULL PRIMARY KEY',
            'languages' => Schema::TYPE_STRING . ' NOT NULL',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);

        $this->createIndex('torrent_language_created_at', '{{%torrent_language}}', 'created_at');
    }

    public function safeDown() {
        $this->dropTable('{{%torrent_language}}');
    }

}
