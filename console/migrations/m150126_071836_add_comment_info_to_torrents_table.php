<?php

use yii\db\Schema;
use yii\db\Migration;

class m150126_071836_add_comment_info_to_torrents_table extends Migration
{
    public function up()
    {
        $this->addColumn("{{%torrents}}", "comments_count", Schema::TYPE_INTEGER . " DEFAULT 0");
    }

    public function down()
    {
        $this->dropColumn("{{%torrents}}", "comments_count");
    }
}
