<?php

use yii\db\Schema;
use yii\db\Migration;

class m150123_105847_scrapes_table extends Migration
{
    public function up()
    {
        $this->createTable('scrapes', [
            'id' => Schema::TYPE_PK,
            'torrent_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'status' => 'TINYINT NOT NULL',
            'complete' => Schema::TYPE_INTEGER . ' NOT NULL',
            'incomplete' => Schema::TYPE_INTEGER . ' NOT NULL',
            'downloaded' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        $this->createIndex('torrent_id', 'scrapes', 'torrent_id');
    }

    public function down()
    {
        $this->dropTable('scrapes');

        return true;
    }
}
