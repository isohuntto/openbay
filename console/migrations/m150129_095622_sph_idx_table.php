<?php

use yii\db\Schema;
use yii\db\Migration;

class m150129_095622_sph_idx_table extends Migration
{
    public function up()
    {
        $sql = "CREATE TABLE `sph_idx` (
  `index` varchar(64) NOT NULL,
  `host` varchar(255) NOT NULL,
  `date_merged` datetime DEFAULT NULL,
  `last_merged_id` int(11) DEFAULT NULL,
  `date_delta` datetime DEFAULT NULL,
  `last_delta_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`index`,`host`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        $this->execute($sql);
    }

    public function down()
    {
        $this->dropTable('sph_idx');
    }
}
