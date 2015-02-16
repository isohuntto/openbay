<?php

namespace frontend\modules\search\controllers;
use Yii;
use yii\web\Controller;
use frontend\modules\tag\models\Category;
use frontend\modules\search\models\Search;
use frontend\modules\torrent\models\Torrent;
use yii\data\ArrayDataProvider;
use yii\helpers\Url;
use frontend\modules\search\models\SearchForm;

class DefaultController extends Controller
{

    public function behaviors() {
        return [
            [
                'class' => 'frontend\modules\search\filters\HashFilter',
                'only' => ['index'],
            ],
            [
                'class' => 'frontend\modules\search\filters\SearchRequestFilter',
                'only' => ['index'],
            ],
        ];
    }
    /**
     * Browsing latest torrents by category
     * @return string the rendering result.
     */
    public function actionIndex($q = null, $iht = null, $age = null) {
        if (is_null($q) && is_null($iht) && is_null($age)) {
            $this->redirect(Url::toRoute('/browse'));
        }

        if (!empty($iht)) {
            if (preg_match('#^\d$#sui', $iht) && Category::getTag($iht)) {
                $iht = Category::getTag($iht);
            }
        }

        if (Yii::$app->request->getQueryParam('ihs', null) === '1') {
            $_GET['popular'] = '1';
        }

        $searchModel = new SearchForm();
        $searchModel->setScenario('simple');
        $searchModel->words = $q;
        $searchModel->tags = $iht;
        $searchModel->age = Yii::$app->request->getQueryParam('age', 0);
        $searchModel->popular = empty($_GET['popular']) ? 0 : 1;
        $searchModel->status = empty($status) ? 0 : 1;
        $searchModel->validate();

        $torrents = null;
        $totalCount = 0;

        if (! $searchModel->getErrors()) {
            $torrents = Search::getTorrentDataProvider($searchModel);
            $totalCount = $torrents->getTotalCount();

            if (empty($totalCount)) {
                $words = explode(' ', $searchModel->words);
                if (count($words) > 1) {
                    $searchModel->words = $words;
                    $torrents = Search::getTorrentDataProvider($searchModel);
                    $totalCount = $torrents->getTotalCount();
                }
            }
        } else {
            $torrents = new ArrayDataProvider();
        }

        if (isset($_REQUEST['lucky'])) {
            $t = $torrents->getModels();
            if (count($t)) {
                $tmp = [];
                foreach($t as $torrent)
                    $tmp[$torrent->seeders] = $torrent;
                krsort($tmp);
                $torrent = array_shift($tmp);
                $this->redirect($torrent->getUrl());
                \Yii::$app->end();
            }
        }

        return $this->render('index', [
            'q' => $q,
            'torrents' => $torrents,
            'totalCount' => $totalCount,
            'iht' => $iht
        ]);
    }

    public function actionRecent() {
        $torrents = Search::getRecentTorrentDataProvider();
        return $this->render('recent', [
            'torrents' => $torrents,
        ]);
    }

    public function actionBrowse() {
        $torrentsByTags = Search::getLastTorrentsDataProvider();

        return $this->render('browse', ['torrents' => $torrentsByTags]);
    }

}
