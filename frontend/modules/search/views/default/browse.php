<?php

use yii\helpers\Html;
use frontend\modules\tag\models\Category;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
$this->title = "Browse Torrents";
?>
<div class="browse-cats short-query">
    <?php foreach (Category::$categoriesTags as $tag) {
        $tagLower = mb_strtolower($tag, Yii::$app->charset);
        $tagId = array_search($tag, Category::$categoriesTags);
    ?>
    <div class="bg-white mb p">
        <h3 class="mt0"><a href="<?= Url::toRoute(['/search', 'iht' => $tagId, 'age' => 0]); ?>"><?= Html::encode($tag); ?> Torrents</a></h3>
        <small>
            <a href="<?= Url::toRoute(['/search', 'iht' => $tagId, 'ihs' => 1, 'age' => 1]); ?>">For last day only</a>
        </small>
        <?php if (isset($torrents[$tagLower])) : ?>

            <?= GridView::widget([
                'dataProvider' => $torrents[$tagLower],
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

        <?php /*
            $this->widget('application.widgets.grid.TorrentGridWidget', array(
                'id' => 'serps' . $tag,
                'ajaxUpdate' => false,
                'dataProvider' => new CArrayDataProvider($torrents[$tagLower]),
                'template' => '{items}',
                'initScripts' => false,
                'tag' => $tagLower,
                'renderKeys' => false
            )); */
        endif; ?>
    </div>
    <?php } ?>
</div>
