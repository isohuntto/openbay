<?php
use yii\helpers\Html;
use frontend\assets\AppAsset;
use frontend\modules\tag\models\Category;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <meta charset="utf-8">
    <meta name="description" content="Download music, movies, games, software and much more. The Pirate Bay is the world's largest bittorrent tracker.">
    <meta name="keywords" content="mp3, avi, bittorrent, piratebay, pirate bay, proxy, torrent, torrents, movies, music, games, applications, apps, download, upload, share, kopimi, magnets, magnet">
    <title><?= $this->title ? Html::encode($this->title) . " | " : ""?><?= Html::encode(Yii::$app->params['name']) ?></title>
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>

    <?php if (!isset($this->params['mainPage'])) : ?>
    <div id="header">

            <a href="/" class="img" style="float: left; text-decoration: none;"><img src="/img/TPB_logo_small.png" id="TPBlogo" alt="The Pirate Bay"></a>
            <div id="srchform">
                <?php /* TODO: Change to navbar*/?>
                <div style="margin-bottom: 15px; text-align: left;">
                    <b><a href="/" title="Search Torrents">Search Torrents</a></b>&nbsp;&nbsp;|&nbsp;
                    <a href="<?= Url::toRoute('/browse'); ?>" title="Browse Torrents">Browse Torrents</a>&nbsp;&nbsp;|&nbsp;
                    <a href="<?= Url::toRoute('/recent'); ?>" title="Recent Torrent">Recent Torrents</a>&nbsp;&nbsp;|&nbsp;
                    <?php if (Yii::$app->user->isGuest) : ?>
                        <a href="<?= Url::toRoute('/site/signup'); ?>" title="Sign Up">Sign up</a>&nbsp;&nbsp;|&nbsp;
                        <a href="<?= Url::toRoute('/site/login'); ?>" title="Log In">Log In</a>
                    <?php else : ?>
                        <a href="<?= Url::toRoute('/site/logout'); ?>" title="Sign Out" data-method='post'>Sign Out (<?= Yii::$app->user->identity->username; ?>)</a>
                    <?php endif; ?>
                </div>
                <form method="get" id="q" action="<?= Url::toRoute('/search'); ?>">
                    <input type="search" class="inputbox topsrch" title="Piratesearch" name="q" placeholder="search here..." value="<?=  Html::encode(Yii::$app->request->getQueryParam('q'));?>">
                    <input id="searchBtn" value="" type="submit" class="submitbutton"><br>


                <label title="All"><input name="" type="checkbox" <?php if (!Yii::$app->request->getQueryParam('iht')) : ?>checked<?php endif; ?>>All</label>
                <?php

                $tags = Category::$categoriesTags;
                foreach($tags as $tagId => $tag) { ?>
                    <label title="<?=$tag;?>"><input name="iht" type="checkbox" value="<?=$tagId;?>"<?php if (Yii::$app->request->getQueryParam('iht') == $tagId) : ?>checked<?php endif; ?>><?= $tag; ?></label>
                <?php
                }
                ?>
                </form>
            </div>

    </div>
    <?php else : ?>
        <div style="position: absolute; top: 0; right: 0;">
        <?php if (Yii::$app->user->isGuest) : ?>
            <a href="<?= Url::toRoute('/site/signup'); ?>" title="Sign Up">Sign up</a>&nbsp;&nbsp;|&nbsp;
            <a href="<?= Url::toRoute('/site/login'); ?>" title="Log In">Log In</a>
        <?php else : ?>
            <a href="<?= Url::toRoute('/site/logout'); ?>" title="Sign Out" data-method='post'>Sign Out (<?= Yii::$app->user->identity->username; ?>)</a>
        <?php endif; ?>
        </div>
    <?php endif; ?>

<?= $content; ?>



<footer>
    <nav>
        Works on Open Bay engine <a href="http://openbay.isohunt.to">http://openbay.isohunt.to</a>
    </nav>

</footer>

    <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
<script>
    $(function() {
        var inputCheckBox = $('input[type=checkbox]');
        inputCheckBox.click(function() {
            inputCheckBox.attr('checked', false);
            this.checked = true;
        });
    });
</script>