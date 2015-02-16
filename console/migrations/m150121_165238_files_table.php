<?php

use yii\db\Schema;
use yii\db\Migration;

class m150121_165238_files_table extends Migration
{
    public function up()
    {
        $this->createTable('files', [
            'id' => Schema::TYPE_PK,
            'torrent_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'name' => Schema::TYPE_TEXT . ' NOT NULL',
            'size' => Schema::TYPE_BIGINT . ' NOT NULL',
            'KEY `torrent_id` (`torrent_id`)'
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8');
    }

    public function down()
    {
        $this->dropTable('files');
        return true;
    }
}
