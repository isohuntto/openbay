<?php

use yii\db\Schema;
use yii\db\Migration;

class m150224_180906_create_followers_table extends Migration
{
    public function up()
    {
        $this->createTable('followers', [
            'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'follower_user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        $this->createIndex('followers', 'followers', ['user_id', 'follower_user_id'], true);
        $this->addPrimaryKey('followers_pk', 'followers', ['user_id', 'follower_user_id']);
    }

    public function down()
    {
        $this->dropTable('followers');
    }
}
