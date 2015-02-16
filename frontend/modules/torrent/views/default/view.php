<?php

use yii\helpers\Html;
use yii\grid\GridView;
use frontend\modules\torrent\assets\ModuleAsset;
use frontend\modules\comment\widgets\CommentWidget;
use frontend\modules\rating\widgets\RatingWidget;
use frontend\modules\complain\widgets\ComplainWidget;
use \frontend\widgets\Alert;

/* @var $this yii\web\View */
/* @var $model frontend\modules\torrent\models\Torrent */

ModuleAsset::register($this);

$this->title = 'Download ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('torrent', 'Torrents'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div id="detailsouterframe">
    <?= Alert::widget(); ?>

    <div id="detailsframe">
        <div id="title">
            <?= Html::a($model->name . ' torrent', $model->getUrl(), ['class' => 'link-textcolor vm']); ?>
        </div>

        <div id="details">
            <dl class="col1">
                <dt>Type:</dt>
                <dd>
                    <?php //TODO replace search link ?>
                    <?= Html::a(ucfirst($model->getCategoryTag()), '/search?iht=' . $model->category_id); ?>
                </dd>

                <dt>Files:</dt>
                <dd><?= $model->getFilesDataProvider()->getCount(); ?></dd>

                <dt>Size:</dt>
                <dd><?= Yii::$app->formatter->asShortSize($model->size); ?></dd>

                <dt>Seeders:</dt>
                <dd><?= number_format($model->seeders, 0, '.', ' '); ?></dd>

                <dt>Leechers:</dt>
                <dd><?= number_format($model->leechers, 0, '.', ' '); ?></dd>
                <br>
                <dt>Info Hash:</dt>
                <dd><?= $model->hash; ?></dd>
                <br>
                <dt>Rating (Votes):</dt>
                <dd><b><span id="rating-avg"><?= number_format($model->rating_avg, 2) ?></span></b> (<span id="rating-votes"><?= $model->rating_votes ?></span>)&nbsp;<?= RatingWidget::widget(['recordId' => $model->id]) ?></dd>
                <br>
                <dt>Complain:</dt>
                <dd><?= ComplainWidget::widget(['recordId' => $model->id]) ?></dd>

            </dl>

            <br><br>

            <div style="position:relative;">
                <div class="download">
                    <?= Html::a('&nbsp;MAGNET LINK', $model->getMagnetLink(), [
                        'title' => 'MAGNET LINK',
                        'style' => 'background-image: url(\'/img/icons/magnet.png\');'
                    ]); ?>
                    <?= Html::a('.TORRENT FILE', $model->getDownloadLink(), ['title' => '.TORRENT FILE']); ?>
                </div>
                <div class="nfo">
                    <?= $model->getPreparedDescription(); ?>
                </div>
                <br>

                <div class="download">
                    <?= Html::a('&nbsp;MAGNET LINK', $model->getMagnetLink(), [
                        'title' => 'MAGNET LINK',
                        'style' => 'background-image: url(\'/img/icons/magnet.png\');'
                    ]); ?>
                    <?= Html::a('.TORRENT FILE', $model->getDownloadLink(), ['title' => '.TORRENT FILE']); ?>
                </div>

                <div id="filelistContainer" style="display:none;">
                    <a id="show"></a>
                </div>
            </div>

            <br><br>

            <div style="position:relative;">
                <h4>Torrent files:</h4>
                <?= GridView::widget([
                    'dataProvider' => $model->getFilesDataProvider(),
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'name',
                        [
                            'attribute' => 'size',
                            'value' => function ($model) {
                                return Yii::$app->formatter->asShortSize($model->size);
                            }
                        ]
                    ]
                ]); ?>
            </div>

            <div>
                <?=
                CommentWidget::widget([
                    'recordId' => $model->id,
                    'defaultComment' => [
                        'The comment has been drowned like a holey schooner.',
                        'The comment has been drowned by other disappointed pirates.',
                        'The filibuster has been pillaged by other pirates.'
                    ]
                ]) ?>
            </div>
        </div>
    </div>
</div>