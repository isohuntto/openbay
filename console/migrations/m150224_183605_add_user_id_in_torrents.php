<?php

use yii\db\Schema;
use yii\db\Migration;

class m150224_183605_add_user_id_in_torrents extends Migration
{
    public function up()
    {
        $this->addColumn('torrents', 'user_id', Schema::TYPE_INTEGER);
        $this->createIndex('torrents_user_id', 'torrents', 'user_id');
        $this->addForeignKey('torrents_user_id_fk', 'torrents', 'user_id', 'user', 'id');
    }

    public function down()
    {
        $this->dropColumn('torrents', 'user_id');
    }
}
