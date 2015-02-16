<?php

namespace common\modules\torrent_scraper\models;

use common\models\torrent\Torrent;
use common\models\torrent\Scrape;
use common\modules\torrent_scraper\Module;

class QueueProcessor {

    protected $module = null;

    public function __construct(Module $module)
    {
        $this->module = $module;
    }

    /**
     * Update scrape info for queue
     */
    public function run()
    {
        $queue = ScrapesQueue::find()->orderBy('id asc')->limit(1000)->all();
        if ($queue) {

            $this->scrapeTorrentsByQueue($queue);

            $this->updateTorrentsScrapeDateByQueue($queue);

            $this->clearQueue($queue);
        }
    }

    /**
     * @param array $queue
     * @return bool
     */
    protected function scrapeTorrentsByQueue(array $queue)
    {
        $list = [];
        /** @var \common\modules\torrent_scraper\models\ScrapesQueue $item */
        foreach ($queue as $item) {
            $list[] = $item->torrent_id;
        }
        if (empty($list)) {
            return;
        }

        $sql = 'select s.id, t.hash, t.id as torrent_id, s.name from scrapes s
left join torrents t on s.torrent_id = t.id
where s.status = :status and torrent_id in (' . join(',', $list) . ')
order by s.name';

        $list = \Yii::$app->db->createCommand($sql, [':status' => Scrape::STATUS_GOOD])->queryAll();

        $hashList = [];
        $scrapeList = [];
        $currentName = null;

        foreach ($list as $item) {
            if ($currentName != $item['name']) {
                if (!empty($hashList)) {
                    $this->runScrape($currentName, $hashList, $scrapeList);
                }
                $currentName = $item['name'];
                $hashList = [];
                $scrapeList = [];
            }
            $hashList[] = $item['hash'];
            $scrapeList[$item['id']] = [
                'torrentId' => $item['torrent_id'],
                'hash' => $item['hash'],
            ];
        }
        if (!empty($hashList)) {
            $this->runScrape($currentName, $hashList, $scrapeList);
        }
    }

    /**
     * @param string $name
     * @param array $hashList
     * @param array $scrapeList
     */
    protected function runScrape($name, array $hashList, array $scrapeList)
    {
        $result = $this->module->scrape($name, $hashList);
        $this->updateScrapes($name, $result, $scrapeList);
    }

    /**
     * @param string $name
     * @param $files
     * @param array $scrapeList
     * @throws \yii\db\Exception
     */
    protected function updateScrapes($name, $files, array $scrapeList)
    {
        $insert = [];
        $delete = [];
        $bad = [];
        foreach ($scrapeList as $scrapeId => $item) {
            if (empty($files[$item['hash']])) {
                $bad[] = $scrapeId;
            } else {

                $file = $files[$item['hash']];

                $fields = [
                    $item['torrentId'],
                    $name,
                    Scrape::STATUS_GOOD,
                    empty($file['complete']) ? 0 : $file['complete'],
                    empty($file['incomplete']) ? 0 : $file['incomplete'],
                    empty($file['downloaded']) ? 0 : $file['downloaded'],
                ];

                $delete[] = $scrapeId;
                $insert[] = $fields;
            }
        }

        if (!empty($bad)) {
            Scrape::updateAll([
                'status' => Scrape::STATUS_BAD,
            ], 'id in ("' . join('","', $bad) . '")');
        }
        if (!empty($delete) && !empty($insert)) {
            Scrape::deleteAll('id in ("' . join('","', $delete) . '")');
            \Yii::$app->db->createCommand()->batchInsert('scrapes'
                , ['torrent_id', 'name', 'status', 'complete', 'incomplete', 'downloaded']
                , $insert)->execute();
        }
    }

    /**
     * @param array $queue
     */
    protected function updateTorrentsScrapeDateByQueue(array $queue)
    {
        $list = [];
        /** @var \common\modules\torrent_scraper\models\ScrapesQueue $item */
        foreach ($queue as $item) {
            $list[] = $item->torrent_id;
        }
        if (empty($list)) {
            return;
        }
        Torrent::updateAll([
            'scrape_date' => date('Y-m-d H:i:s'),
        ], 'id in ("' . join('","', $list) . '")');
    }

    /**
     * @param array $queue
     */
    protected function clearQueue(array $queue)
    {
        $list = [];
        /** @var \common\modules\torrent_scraper\models\ScrapesQueue $item */
        foreach ($queue as $item) {
            $list[] = $item->id;
        }

        ScrapesQueue::deleteAll('id in (' . join(',', $list) . ')');
    }
}