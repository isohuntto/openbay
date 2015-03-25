<?php

use yii\grid\DataColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use frontend\modules\feed\widgets\FollowWidget;

$searchQuery = "";
/* @var $this yii\web\View */

$this->title = $user->username . ' Torrents';

$tmpPage = \Yii::$app->request->get('page');
$page = intval($tmpPage) > 0 ? intval($tmpPage) : 1;
$pageSize = $torrents->pagination->pageSize;
?>

<?=

GridView::widget([
    'dataProvider' => $torrents,
    'tableOptions' => [
        'class' => 'result search-result',
    ],
    'layout' => '<div class="title">
                        <h2 class="left">Torrents uploaded by ' . $user->username . '</h2>' .
                        FollowWidget::widget(['user' => $user]) .
                        '<div class="clear"></div>
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
]);
?>
