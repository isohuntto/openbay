<?php

use yii\grid\DataColumn;
use yii\grid\GridView;
use \yii\helpers\Html;
use \frontend\modules\follower\widgets\FollowerWidget;

/* @var $this yii\web\View */

$this->title = ucfirst($user->username) . "'s torrents";
?>

<p><?= FollowerWidget::widget(['username' => $user->username]); ?></p>

<?=
GridView::widget([
    'dataProvider' => $torrents,
    'tableOptions' => [
        'class' => 'result',
    ],
    'layout' => '{summary}<div class="panel panel-default"><div class="table-responsive">{items}</div><div class="table-footer"><div class="navigation">{pager}</div></div></div>',

    'summary' => '
        <div class="title">
            <h2 class="left"><span class="bold">'.Html::encode($this->title).'</span></h2>
            <span class="right font-12">Displaying hits from {begin} to {end}</span>
            <div class="clear"></div>
        </div>',
    'emptyText' => "Blimey! Nothing was found.",
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
            'class' => DataColumn::className(),
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