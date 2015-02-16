<?php
namespace common\modules\torrent_scraper;

use common\modules\torrent_scraper\models\QueueProcessor;
use common\modules\torrent_scraper\models\ScraperException;
use common\modules\torrent_scraper\models\ScrapesQueue;
use common\modules\torrent_scraper\models\Tracker;
use common\modules\torrent_scraper\models\HttpScraper;
use common\modules\torrent_scraper\models\UdpScraper;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'common\modules\torrent_scraper';

    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }

    /**
     * @param string $url
     * @param array $hashes
     * @return array|bool
     */
    public function scrape($url, array $hashes)
    {
        $tracker = Tracker::parse($url);
        if (empty($tracker)) {
            return false;
        }

        $scraper = $this->getScraperByScheme($tracker->scheme);
        if (empty($scraper)) {
            return false;
        }

        try {
            return $scraper->scrape($tracker, $hashes);
        } catch (ScraperException $e) {
            return false;
        }
    }

    /**
     * @param string $scheme
     * @return HttpScraper|UdpScraper|null
     */
    protected function getScraperByScheme($scheme)
    {
        switch ($scheme) {
            case 'http':
            case 'https':
                return new HttpScraper();
            case 'udp':
                return new UdpScraper();
            default:
                return null;
        }
    }

    /**
     * @param int $torrentId
     */
    public function queuedTorrent($torrentId)
    {
        $model = new ScrapesQueue();
        $model->torrent_id = $torrentId;
        if ($model->validate()) {
            $model->save();
        }
    }

    /**
     * Update scrape info for queue
     */
    public function processQueue()
    {
        $model = new QueueProcessor($this);
        $model->run();
    }
}
