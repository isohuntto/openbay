<?php

use yii\helpers\Html;
use frontend\modules\tag\models\Category;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
if (!empty($q)) {
    $this->title = ucfirst($q) . ' Torrents Search Results';
} elseif (!empty($iht)) {
    $this->title = mb_convert_case($iht, MB_CASE_TITLE, 'utf-8') . ' Torrents';
} else {
    $this->title = "Search";
}
?>

<div class="p bg-white mb">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $torrents,
        'tableOptions' => [
            'class' => 'table-torrents table table-striped table-bordered',
        ],
        'summary' => false,
        'emptyText' => "Blimey! Nothing was found. Try to search again with a different query.",
        'columns' => [
            [
                'class' => frontend\widgets\grid\TorrentTitleColumn::className(),
                'attribute' => 'name',
                'label' => 'Torrents'
            ],
            [
                'class' => frontend\widgets\grid\TorrentAgeColumn::className(),
                'attribute' => 'created_at',
                'label' => 'Age'
            ],
            [
                'class' => frontend\widgets\grid\TorrentSizeColumn::className(),
                'attribute' => 'size',
                'label' => 'Size'
            ],
            [
                'attribute' => 'seeders',
                'label' => 'S',
            ],
            [
                'attribute' => 'leechers',
                'label' => 'L',
            ],
        ],
        'pager' => [
            'options' => [
                'class' => 'pagination',
            ],
            'firstPageLabel' => '««',
            'lastPageLabel' => '»»',
            'nextPageLabel' => '»',
            'prevPageLabel' => '«',
        ]
    ]); ?>

</div>
