<?php

use yii\grid\DataColumn;
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = "Following";

$msg = \Yii::$app->session->getFlash('result');
?>

<?php if (!empty($msg)): ?>
    <p><?= $msg[0] ?></p>
<?php endif; ?>

<?=
GridView::widget([
    'dataProvider' => $dataProvider,
    'tableOptions' => [
        'class' => 'result',
    ],
    'layout' => '{summary}<div class="panel panel-default"><div class="table-responsive">{items}</div><div class="table-footer"><div class="navigation">{pager}</div></div></div>',

    'summary' => '
        <div class="title">
            <h2 class="left"><span class="bold">Following</span></h2>
            <span class="right font-12">Displaying hits from {begin} to {end}</span>
            <div class="clear"></div>
        </div>',
    'emptyText' => "Blimey! Nothing was found.",
    'columns' => [
        [
            'class' => DataColumn::className(),
            'options' => ['style' => 'width:100%'],
            'contentOptions' => ['class' => 'v-middle font-12'],
            'attribute' => 'username',
            'label' => 'Username',
            'format' => 'html',
            'value' => function($user) {
                return Html::a($user->username, '/torrents/'.$user->username);
            },
        ],
        [
            'class' => DataColumn::className(),
            'options' => ['style' => 'width:100%'],
            'contentOptions' => ['class' => 'v-middle font-12'],
            'label' => 'Actions',
            'format' => 'html',
            'value' => function($user) {
                return Html::a('Unfollow', '/unfollow/'.$user->username);
            },
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