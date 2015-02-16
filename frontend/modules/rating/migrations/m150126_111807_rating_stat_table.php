<?php

use yii\db\Schema;
use yii\db\Migration;

class m150126_111807_rating_stat_table extends Migration
{
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%rating_stats}}', [
            'record_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'rating' => Schema::TYPE_SMALLINT . ' NOT NULL',
            'count' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);

        $this->addPrimaryKey("rating_stat_pk", "{{%rating_stats}}", [
            'record_id', 'rating'
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%rating_stats}}');
    }
}
