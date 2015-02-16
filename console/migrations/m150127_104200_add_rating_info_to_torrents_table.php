<?php

use yii\db\Schema;
use yii\db\Migration;

class m150127_104200_add_rating_info_to_torrents_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn("{{%torrents}}", "rating_votes", Schema::TYPE_INTEGER . " DEFAULT 0");
        $this->addColumn("{{%torrents}}", "rating_avg", Schema::TYPE_FLOAT . " DEFAULT 0.00");
    }

    public function safeDown()
    {
        $this->dropColumn("{{%torrents}}", "rating_votes");
        $this->dropColumn("{{%torrents}}", "rating_avg");
    }
}
