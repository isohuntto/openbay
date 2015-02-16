<?php

use yii\helpers\Html;
use frontend\modules\tag\models\Category;
use yii\grid\GridView;
use yii\grid\DataColumn;
use yii\helpers\Url;

/* @var $this yii\web\View */
$this->title = "Browse Torrents";
$this->params['isBrowse'] = true;
?>

<?php foreach (Category::$categoriesTags as $tag):
    $tagLower = mb_strtolower($tag, Yii::$app->charset);
    $tagId = array_search($tag, Category::$categoriesTags);
    ?>
    <div class="torrents">
        <div class="title">
            <h2><a href="<?= Url::toRoute(['/search', 'iht' => $tagId, 'age' => 0]); ?>"
                   class="bold border-none"><?= Html::encode($tag); ?></a></h2>
        </div>
        <!--<a href="<?= Url::toRoute(['/search', 'iht' => $tagId, 'ihs' => 1, 'age' => 1]); ?>">For last day only</a>-->
        <?php if (isset($torrents[$tagLower])) : ?>

            <?=
            GridView::widget([
                'dataProvider' => $torrents[$tagLower],
                'tableOptions' => [
                    'class' => 'result',
                ],
                'summary' => false,
                'columns' => [
                    [
                        'class' => frontend\widgets\grid\TorrentTitleColumn::className(),
                        'options' => ['style' => 'width:74%'],
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
                'pager' => false
            ]); ?>
        <?php endif; ?>

    </div>
<?php endforeach; ?>