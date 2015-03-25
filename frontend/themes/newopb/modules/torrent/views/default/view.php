<?php

use yii\helpers\Html;
use yii\grid\GridView;
use frontend\modules\torrent\assets\ModuleAsset;
use frontend\modules\comment\widgets\CommentWidget;
use frontend\modules\rating\widgets\RatingWidget;
use frontend\modules\complain\widgets\ComplainWidget;

/* @var $this yii\web\View */
/* @var $model frontend\modules\torrent\models\Torrent */

ModuleAsset::register($this);

$this->title = 'Download ' . $model->name;
$this->params['isBrowse'] = true;
$this->params['breadcrumbs'][] = ['label' => Yii::t('torrent', 'Torrents'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$date = new \DateTime($model->created_at);
?>


<div class="title">
    <h2><?= Html::a($model->name, $model->getUrl(), ['class' => 'bold border-none'])?></h2>
</div>
<div class="torrent-details">
    <div>
        <div class="details-info left">
            <div class="details-info-block">
                <p><strong>Type:</strong> <?= Html::a(ucfirst($model->getCategoryTag()), '/search?iht=' . $model->category_id); ?></p>
                <p><strong>Files:</strong> <a href="#" class="dashed files-numbers"><?= $model->getFilesDataProvider()->getCount(); ?></a></p>
                <p><strong>Size:</strong> <span><?= Yii::$app->formatter->asShortSize($model->size); ?></span></p>
            </div>
            <div class="details-info-block">
                <p><strong>Seeders:</strong> <span><?= number_format($model->seeders, 0, '.', ' '); ?></span></p>
                <p><strong>Leechers:</strong> <span><?= number_format($model->leechers, 0, '.', ' '); ?></span></p>
                <p><strong>Info hash:</strong> <span><?= $model->hash; ?></span></p>
            </div>
            <div class="details-info-block">
                <p><strong>Uploaded:</strong> <span><?= $date->format('j F Y, G:i') ?></span> by <?= Html::a($model->user->username, '/torrents/'.$model->user->username) ?></p>
            </div>
            <div>
                <p><strong>Comment:</strong> <span><?= $model->comments_count ?></span> <a href="#box-comment" class="dashed id-link" >write comment</a> <i class="icon-12 dialo v-sub"></i></p>
            </div>
        </div>
        <div class="right txt-center rating-block">
            <a href="#" class="block dashed color-bluez">Votes: <span id="rating-votes"><?= $model->rating_votes ?></span></a>
            <div class="rating-number"><span id="rating-avg"><?= number_format($model->rating_avg, 1) ?></span></div>
            <?= RatingWidget::widget(['recordId' => $model->id]) ?>
        </div>
        <div class="clear"></div>
    </div>
    <div class="icon-link">
        <ul>
            <li>
                <?= Html::a('<i class="icon-20 magnet"></i>MAGNET LINK', $model->getMagnetLink()); ?>
            </li>
            <li>
                <?= Html::a('<i class="icon-20 torrent"></i>.TORRENT FILE', $model->getDownloadLink()); ?>
            </li>
            <div class="right">
                <?= ComplainWidget::widget(['recordId' => $model->id]) ?>
            </div>
            <div class="clear"></div>
        </ul>
    </div>
    <div class="description description-files none">
        <?= GridView::widget([
            'dataProvider' => $model->getFilesDataProvider(),
            'tableOptions' => [
                'style' => 'width: 100%;',
            ],
            'columns' => [
                [
                    'class' => 'yii\grid\SerialColumn',
                    'options' => ['style' => 'width:5%'],
                ],
                [
                    'attribute' => 'name',
                    'options' => ['style' => 'width:85%'],
                ],
                [
                    'attribute' => 'size',
                    'options' => ['style' => 'width:10%'],
                    'value' => function ($model) {
                            return Yii::$app->formatter->asShortSize($model->size);
                        }
                ]
            ]
        ]); ?>
    </div>
    <div class="description">
        <p><?= $model->getPreparedDescription(); ?></p>
    </div>
    <div class="icon-link">
        <ul>
            <li>
                <?= Html::a('<i class="icon-20 magnet"></i>MAGNET LINK', $model->getMagnetLink()); ?>
            </li>
            <li>
                <?= Html::a('<i class="icon-20 torrent"></i>.TORRENT FILE', $model->getDownloadLink()); ?>
            </li>
            <div class="clear"></div>
        </ul>
    </div>

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