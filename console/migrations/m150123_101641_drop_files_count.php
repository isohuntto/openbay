<?php

use yii\db\Schema;
use yii\db\Migration;

class m150123_101641_drop_files_count extends Migration
{
    public function up()
    {
        $this->dropColumn('torrents', 'files_count');
    }

    public function down()
    {
        /*
         * make revert from tags field if needed
         */
        echo "m150123_101641_drop_files_count cannot be reverted.\n";

        return false;
    }
}
