<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\helpers\Console;

class ScrapeController extends Controller
{

    public function actionIndex()
    {
        $this->stdout('scrape index' . PHP_EOL, Console::FG_GREEN);

    }

    public function actionQueue()
    {
        /** @var \common\modules\torrent_scraper\Module $module */
        $module = Yii::$app->getModule('torrent_scraper');

        $module->processQueue();
    }
}