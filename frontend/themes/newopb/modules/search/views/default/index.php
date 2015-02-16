<?php

use yii\grid\DataColumn;
use yii\grid\GridView;
use yii\helpers\Html;

$searchQuery = Html::encode(ucfirst($q));
/* @var $this yii\web\View */
if (!empty($q)) {
    $this->title = 'Search result: ' . $searchQuery;
    $searchTitle = 'Search result: <span class="bold">' . $searchQuery . '</span>';
} elseif (!empty($iht)) {
    $this->title = mb_convert_case($iht, MB_CASE_TITLE, 'utf-8') . ' Torrents';
} else {
    $this->title = "Search";
}
$this->params['isSearch'] = true;
$this->params['searchQuery'] = Html::encode($q);

$tmpPage = \Yii::$app->request->get('page');
$page = intval($tmpPage) > 0 ? intval($tmpPage) : 1;
$pageSize = $torrents->pagination->pageSize;
$from = $page == 1 ? 1 : ($page-1)*$pageSize+1;
$to = $page*$pageSize > $totalCount ? $totalCount: $page*$pageSize;
?>


<?=
GridView::widget([
    'dataProvider' => $torrents,
    'tableOptions' => [
        'class' => 'result search-result',
    ],
    'layout' => '<div class="title">
					<h2 class="left">'.($searchTitle ? $searchTitle : $this->title).'</h2>
					<span class="right font-12">Displaying hits from '.$from.' to '.$to.' (approx '.$totalCount.' found)</span>
					<div class="clear"></div>
				</div>{summary}<div class="panel panel-default"><div class="table-responsive">{items}</div><div class="table-footer"><div class="navigation">{pager}</div></div></div>',

    'summary' => false,
    'emptyText' => "Blimey! Nothing was found. Try to search again with a different query.",
    'columns' => [
        [
            'class' => frontend\widgets\grid\TorrentTypeColumn::className(),
            'options' => ['style' => 'width:10%'],
            'label' => 'Type',
        ],
        [
            'class' => frontend\widgets\grid\TorrentTitleColumn::className(),
            'options' => ['style' => 'width:64%'],
            'label' => 'Name',
            'attribute' => 'name',
        ],
        [
            'class' => frontend\widgets\grid\TorrentAgeColumn::className(),
            'options' => ['style' => 'width:8%'],
            'contentOptions' => ['class' => 'v-middle font-12'],
            'label' => 'Age',
            'attribute' => 'created_at',
        ],
        [
            'class' => frontend\widgets\grid\TorrentSizeColumn::className(),
            'options' => ['style' => 'width:8%'],
            'contentOptions' => ['class' => 'v-middle font-12'],
            'label' => 'Size',
            'attribute' => 'size',
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
