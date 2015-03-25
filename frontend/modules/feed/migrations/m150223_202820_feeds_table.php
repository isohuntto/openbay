<?php

use yii\db\Schema;
use yii\db\Migration;

class m150223_202820_feeds_table extends Migration {

    public function up() {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%user_feeds}}', [
            'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'following_id' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);

        $this->addPrimaryKey("user_feeds_pk", "{{%user_feeds}}", [
            'user_id', 'following_id'
        ]);
        $this->addForeignKey("user_feeds_user_id", "{{%user_feeds}}", "user_id", "user", "id");
        $this->addForeignKey("user_feeds_following_id", "{{%user_feeds}}", "following_id", "user", "id");
    }

    public function down() {
        $this->dropTable('{{%user_feeds}}');
    }

}
