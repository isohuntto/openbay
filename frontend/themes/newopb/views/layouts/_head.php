<?php
use frontend\assets\NewopbAsset;
use frontend\modules\tag\models\Category;
use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */

NewopbAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta charset="utf-8" />

        <!--[if IE]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
        <?= Html::csrfMetaTags() ?>
        <title><?= $this->title ? Html::encode($this->title) . " | " : ""?><?= Html::encode(Yii::$app->params['name']) ?></title>

        <meta name="keywords" content="mp3, avi, bittorrent, piratebay, pirate bay, proxy, torrent, torrents, movies, music, games, applications, apps, download, upload, share, kopimi, magnets, magnet" />
        <meta name="description" content="Download music, movies, games, software and much more. The Pirate Bay is the world's largest bittorrent tracker." />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
        <?php $this->head() ?>
    </head>
    <body class="main">
        <?php $this->beginBody() ?>
