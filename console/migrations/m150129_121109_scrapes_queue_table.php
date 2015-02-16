<?php

use yii\db\Schema;

class m150129_121109_scrapes_queue_table extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('scrapes_queue', [
            'id' => Schema::TYPE_PK,
            'torrent_id' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        $this->createIndex('torrent_id', 'scrapes_queue', 'torrent_id', true);
    }

    public function down()
    {
        $this->dropTable('scrapes_queue');
        return true;
    }
}
