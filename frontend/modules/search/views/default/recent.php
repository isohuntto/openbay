<?php

use yii\helpers\Html;
use frontend\modules\tag\models\Category;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = "Latest Torrents";

?>

<div class="p bg-white mb">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $torrents,
        'tableOptions' => [
            'class' => 'table-torrents table table-striped table-bordered',
        ],
        'summary' => false,
        'columns' => [
            ['class' => frontend\widgets\grid\TorrentTitleColumn::className(),],
            ['class' => frontend\widgets\grid\TorrentAgeColumn::className()],
            ['class' => frontend\widgets\grid\TorrentSizeColumn::className()],
            [
                'attribute' => 'seeders',
                'header' => 'S',
            ],
            [
                'attribute' => 'leechers',
                'header' => 'L',
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
