<?php

use yii\grid\DataColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */

$this->title = "Latest Torrents";

$this->params['isRecent'] = true;

$tmpPage = \Yii::$app->request->get('page');
$page = intval($tmpPage) > 0 ? intval($tmpPage) : 1;
$pageSize = $torrents->pagination->pageSize;
$from = $page == 1 ? 1 : ($page-1)*$pageSize+1;
$to = $page*$pageSize > 10000 ? 10000: $page*$pageSize;
?>

<?=
GridView::widget([
    'dataProvider' => $torrents,
    'tableOptions' => [
        'class' => 'result',
    ],
    'layout' => '<div class="title">
                <h2 class="left"><span class="bold">Latest Torrents</span></h2>
                <span class="right font-12">Displaying hits from '.$from.' to '.$to.'</span>
                <div class="clear"></div>
            </div>{summary}<div class="panel panel-default"><div class="table-responsive">{items}</div><div class="table-footer"><div class="navigation">{pager}</div></div></div>',

    'summary' => false,
    'emptyText' => "Blimey! Nothing was found. Try to search again with a different query.",
    'columns' => [
        [
            'class' => frontend\widgets\grid\TorrentTitleColumn::className(),
            'options' => ['style' => 'width:64%'],
            'label' => 'Name',
        ],
        [
            'class' => frontend\widgets\grid\TorrentAgeColumn::className(),
            'options' => ['style' => 'width:8%'],
            'contentOptions' => ['class' => 'v-middle font-12'],
            'label' => 'Age',
        ],
        [
            'class' => frontend\widgets\grid\TorrentSizeColumn::className(),
            'options' => ['style' => 'width:8%'],
            'contentOptions' => ['class' => 'v-middle font-12'],
            'label' => 'Size',
        ],
        [
            'class' => \yii\grid\DataColumn::className(),
            'options' => ['style' => 'width:5%'],
            'contentOptions' => ['class' => 'v-middle font-12'],
            'attribute' => 'seeders',
            'label' => 'SE',
        ],
        [
            'class' => DataColumn::className(),
            'options' => ['style' => 'width:5%'],
            'contentOptions' => ['class' => 'v-middle font-12'],
            'attribute' => 'leechers',
            'label' => 'LE',
        ],
    ],
    'pager' => [
        'options' => [
            'class' => 'center',
        ],
        'activePageCssClass' => 'disabled',
        'firstPageCssClass' => 'border-none',
        'lastPageCssClass' => 'border-none',
        'nextPageCssClass' => 'border-none',
        'prevPageCssClass' => 'border-none',
        'firstPageLabel' => '<i class="icon-12 two-left-arrow v-sub"></i>',
        'lastPageLabel' => '<i class="icon-12 two-right-arrow v-sub"></i>',
        'nextPageLabel' => '<i class="icon-12 one-right-arrow v-sub"></i>',
        'prevPageLabel' => '<i class="icon-12 one-left-arrow v-sub"></i>',
    ]
]); ?>