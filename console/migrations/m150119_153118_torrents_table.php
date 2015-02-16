<?php

use yii\db\Schema;
use yii\db\Migration;

class m150119_153118_torrents_table extends Migration
{
    public function up()
    {
        $sql = "CREATE TABLE `torrents` (
                    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                    `name` varchar(255) DEFAULT NULL,
                    `description` text,
                    `category_id` tinyint(4) DEFAULT NULL,
                    `size` bigint(20) unsigned DEFAULT NULL,
                    `hash` varchar(40) NOT NULL,
                    `files_count` int(11) DEFAULT '0',
                    `created_at` datetime DEFAULT NULL,
                    `torrent_status` smallint(2) DEFAULT '0',
                    `visible_status` smallint(2) DEFAULT '0',
                    `downloads_count` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT 'umax = 16777215',
                    `scrape_date` datetime DEFAULT NULL,
                    `seeders` mediumint(8) unsigned NOT NULL DEFAULT '0',
                    `leechers` mediumint(8) unsigned NOT NULL DEFAULT '0',
                    `tags` varchar(500) DEFAULT NULL,
                    `updated_at` datetime DEFAULT NULL,
                    PRIMARY KEY (`id`),
                    UNIQUE KEY `hash` (`hash`),
                    KEY `created_at` (`created_at`),
                    KEY `size` (`size`),
                    KEY `seeders` (`seeders`),
                    KEY `category_id_torrent_status_visible_status` (`category_id`,`torrent_status`,`visible_status`)
                  ) ENGINE=InnoDB DEFAULT CHARSET=utf8";
        $this->execute($sql);
    }

    public function down()
    {
        $this->dropTable('torrents');
    }
}
