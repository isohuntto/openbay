<?php

class MainController extends Controller
{
    public function actionIndex() {
        $this->mainPage = true;

        $this->render('index');
    }

    public function actionError() {
        $this->render('/errors/error404');
    }

    public function actionRecent()
    {
        $this->pageTitle = 'New Torrents | ' . Yii::app()->name . ' Torrent Search Engine';

        $pagination = new Pagination(9975);
        $pagination->setPageSize(35);

        $torrents = new CActiveDataProvider(LTorrent::model(), array(
            'criteria' => array(
                'scopes' => array(
                    'allowed'
                )
            ),
            'sort' => array(
                'sortVar' => 'Torrent_sort',
                'defaultOrder' => array(
                    'id' => CSort::SORT_DESC
                ),
                'attributes' => LTorrent::$defaultSortAttributes,
            ),
            'pagination' => $pagination,
        ));

        if (empty($torrents)) {
            Yii::log('Empty latest torrents set', CLogger::LEVEL_ERROR);
        }

        $this->render('latest', array(
            'torrents' => $torrents
        ));
    }

    public function actionTorrent($id)
    {
        $torrent = LTorrent::model()->findByPk($id);

        $this->pageTitle = 'Download ' . $torrent->name . ' - ' . Yii::app()->name;
        $cleanDescription = $torrent->description;
        $torrent->description = $this->purifyHtml($torrent->description);

        Yii::app()->clientScript->registerScript('torrent-view', CClientScript::POS_HEAD);

        $this->render('view', array(
            'torrent' => $torrent,
            'cleanDescription' => $cleanDescription,
        ));
    }

    private function checkRequestUri($uri)
    {
        if ($uri !== Yii::app()->request->getRequestUri()) {
            $this->redirect($uri, true, 301);
        }
    }

    protected function purifyHtml($html)
    {
        // remove bad parsing
        $html = preg_replace('#\\\r\\\n|\\\r|\\\n|\\\#sui', '', $html);
        $p = new CHtmlPurifier();
        $p->options = array(
            'HTML.Allowed' => 'img[src],p,br,b,strong,i'
        );
        $html = $p->purify($html);
        $p->options = array(
            'HTML.Allowed' => ''
        );
        $text = $p->purify($html);
        if (mb_strlen($text, 'UTF-8') === mb_strlen($html, 'UTF-8')) {
            return '<pre>' . $text . '</pre>';
        }

        return $html;
    }

    public function actionBrowse($q = null, $iht = null, $status = 0)
    {
        if ($q || $iht) {
            return $this->actionSearch($q, $iht, $status);
        }

        return $this->actionCategories();
    }

    protected function checkSearchRequest() {
        $uri = Yii::app()->getRequest()->getRequestUri();
        if (preg_match('#q=([^&]+)#', $uri, $matches)) {
            $q = $matches[1];
            $filtered = preg_replace('#(\s|%20)#ui', '+', $q);
            $filtered = preg_replace('#%2B#ui', '+', $filtered);
            $filtered = preg_replace('#\+{2,}#', '+', $filtered);
            $filtered = trim($filtered, '+');
            $filteredUri = str_replace($q, $filtered, $uri);
            if ($uri !== $filteredUri) {
                $this->redirect($filteredUri);
            }
        }
    }

    public function actionSearch($q = null, $iht = null, $status = null)
    {
        $queryLength = mb_strlen($q, 'UTF-8');
        // search by hash
        $is_hash = false;

        if (40 == $queryLength && preg_match('#^[0-9a-f]{40}$#i', $q)) {
            $is_hash = true;
            if ($torrent = Yii::app()->torrentsService->getTorrentByHash($q)) {
                Yii::app()->request->redirect($torrent->getUrl());
            }
        }

        $this->checkSearchRequest();

        if (!empty($iht)) {
            if (preg_match('#^\d$#sui', $iht) && LCategory::getCategoryTag($iht)) {
                $iht = LCategory::getCategoryTag($iht);
            }
        }
        if (!empty($q)) {
            $this->pageTitle = ucfirst($q) . ' Torrents Search Results | ' . Yii::app()->name . ' Torrent Search Engine';
        } elseif (!empty($iht)) {
            $this->pageTitle = mb_convert_case($iht, MB_CASE_TITLE, 'utf-8') . ' Torrents | ' . Yii::app()->name . ' Torrent Search Engine';
        }

        Yii::app()->getRequest()->getQuery('age');

        if (Yii::app()->getRequest()->getQuery('ihs', null) === '1') {
            $_GET['popular'] = '1';
        }

        $searchModel = new SearchForm('simple');
        $searchModel->words = $q;
        $searchModel->tags = $iht;
        $searchModel->age = Yii::app()->getRequest()->getQuery('age', 0);
        $searchModel->popular = empty($_GET['popular']) ? 0 : 1;
        $searchModel->status = empty($status) ? 0 : 1;
        $searchModel->validate();

        $torrents = new CArrayDataProvider(array());
        $totalCount = 0;

        if (! $searchModel->getErrors()) {
            $torrentModel = LTorrent::model();
            $torrents = $torrentModel->getSphinxDataProvider($searchModel);
            $totalCount = $torrents->getTotalItemCount();

            if (empty($totalCount)) {
                $words = explode(' ', $searchModel->words);
                if (count($words) > 1) {
                    $searchModel->words = $words;
                    $torrents = $torrentModel->getSphinxDataProvider($searchModel);
                    $totalCount = $torrents->getTotalItemCount();
                }
            }
        }

        if (isset($_REQUEST['lucky'])) {
            $t = $torrents->getData();
            if (count($t)) {
                $idx = rand(0, count($t) - 1);
                Yii::app()->request->redirect($t[$idx]->getUrl());
            }
        }

        $this->render('list', array(
            'torrents' => $torrents,
            'search' => $searchModel->words,
            'categoryTag' => $iht,
            'categoriesTags' => LCategory::$categoriesTags,
            'totalFound' => $totalCount,
        ));
    }

    /**
     * Returns SphinxQL search object, initialized for tag search
     *
     * @param SearchForm $model
     * @return \ESphinxQL
     */
    protected function getSphinxTagSearchObject(SearchForm $model) {
        $objCommon = new ESphinxQL();
        $objCommon->addField('id')->addIndex(Yii::app()->params['sphinx']['indexes']['torrents']);

        $tagPatterns = array();
        if ($model->tags) {
            $tagPatterns[] = '"=' . str_replace(' ', '+', $model->tags) . '"';
        }
        if ($model->category) {
            $tagPatterns[] = '"=' . str_replace(' ', '+', LCategory::getCategoryTag($model->category)) . '"';
            $objCommon->where('category_id', $model->category);
        }

        if (count($tagPatterns)) {
            $searchPattern = '@tags ' . join(' ', $tagPatterns);
        }

        $objCommon->option('ranker', 'MATCHANY');

        // Filter torrents by status
        if (! empty($model->status)) {
            $objCommon->where('torrent_status', Torrent::TORRENT_STATUS_GOOD);
        }

        // Filter torrents by age
        if (! empty($model->age)) {
            $objCommon->where('created_at', time() - $model->age * 86400, '>=', true);
        }

        if (! empty($model->popular)) {
            $objCommon->order('downloads_count', 'DESC');
        }

        if ($model->latest) {
            $objCommon->order('created_at', 'DESC');
            $objCommon->limit($model->latest);
        }

        // If no ordering is set - default weight+id sorting mode
        if (!$objCommon->getOrders()) {
            $objCommon->order('weight()', 'DESC');
            $objCommon->order('id', 'DESC');
        }

        if (! empty($searchPattern)) {
            $objCommon->search($searchPattern);
        }

        return $objCommon;
    }

    public function actionCategories()
    {
        $this->pageTitle = 'Browse Torrents | ' . Yii::app()->name . ' Torrent Search Engine';

        $torrentsByTags = array();
        $torrentsIds = LTorrent::getLastTorrentIdsByCategories();

        if (empty($torrentsIds)) {
            Yii::log('Empty last torrents ids', CLogger::LEVEL_WARNING);
        } else {
            $torrentModel = LTorrent::model();
            $criteria = new CDbCriteria();
            $criteria->addInCondition('t.id', $torrentsIds);
            foreach ($torrentModel->findAll($criteria) as $torrent) {
                $torrentsByTags[$torrent->getCategoryTag()][] = $torrent;
            }
        }

        $this->render('categories', array(
            'tags' => LCategory::$categoriesTags,
            'torrents' => $torrentsByTags
        ));
    }


}
