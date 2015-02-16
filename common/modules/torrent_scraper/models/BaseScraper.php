<?php
namespace common\modules\torrent_scraper\models;

abstract class BaseScraper
{
    /**
     * @param Tracker $tracker
     * @param array $hashes
     * @return array
     */
    abstract public function scrape(Tracker $tracker, array $hashes);
}