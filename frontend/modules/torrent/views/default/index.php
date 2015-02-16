<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('torrent', 'Torrents');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="p bg-white mb">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
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
