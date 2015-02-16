<?php
use yii\helpers\Html;
use frontend\assets\NewopbAsset;
use frontend\modules\tag\models\Category;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $content string */

NewopbAsset::register($this);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <?= Html::csrfMetaTags() ?>
        <meta charset="utf-8">
        <meta name="description"
              content="Download music, movies, games, software and much more. The Pirate Bay is the world's largest bittorrent tracker.">
        <meta name="keywords"
              content="mp3, avi, bittorrent, piratebay, pirate bay, proxy, torrent, torrents, movies, music, games, applications, apps, download, upload, share, kopimi, magnets, magnet">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
        <title><?= $this->title ? Html::encode($this->title) . " | " : "" ?><?= Html::encode(Yii::$app->params['name']) ?></title>
        <?php $this->head() ?>

    </head>

    <body>
    <?php $this->beginBody() ?>
    <div class="box-header">
        <div class="wrapper">
            <header>
                <div class="top-menu">
                    <?= Html::a('', ['/'], ['class'=>'block border-none logo-mini', 'title'=>'Home&hellip;', 'id'=>'logo'])?>

                    <div class="top-menu-content">
                        <div class="torrents-menu">
                            <?= Html::a('Search Torrents', ['/'], isset($this->params['isSearch']) ? ['class'=>'disabled'] : [])?>
                            <?= Html::a('Browse Torrents', ['/browse'], isset($this->params['isBrowse']) ? ['class'=>'disabled'] : [])?>
                            <?= Html::a('Recent Torrents', ['/recent'], isset($this->params['isRecent']) ? ['class'=>'disabled'] : [])?>
                        </div>
                        <form method="get" action="<?= Url::toRoute('/search') ?>">
                            <div>
                                <input type="search" class="search" name="q" placeholder="Pirate Search…" value="<?= isset($this->params['searchQuery']) ? $this->params['searchQuery'] : '' ?>"/>
                                <input type="submit" title="Pirate Search" value="Pirate Search" id="searchBtn"
                                       class="button"/>
                            </div>
                            <ul class="checkbox-menu">
                                <li>
                                    <label>
                                        <input name="" type="checkbox" checked/>
                                        <span>All</span>
                                    </label>
                                </li>
                                <?php
                                $tags = Category::$categoriesTags;
                                foreach ($tags as $tagId => $tag) : ?>
                                    <li>
                                        <label title="<?= Html::encode($tag); ?>">
                                            <input name="iht" type="checkbox" value="<?= $tagId; ?>"/>
                                            <span><?= Html::encode($tag); ?></span>
                                        </label>
                                    </li>
                                <?php endforeach; ?>
                                <div class="clear"></div>
                            </ul>
                        </form>
                    </div>

                </div>
            </header>
        </div>
    </div>
    <div class="box-content">
        <div class="wrapper">
            <section>
                <?= $content ?>
            </section>
        </div>
    </div>
    <div class="box-footer">
        <div class="wrapper">
            <footer>
                <div class="center footer">
                    <div class="txt-center">
                        <?php if (Yii::$app->user->isGuest) : ?>
                            <a href="<?= Url::toRoute('/site/login'); ?>" title="Login">Login</a> | <a href="<?= Url::toRoute('/site/signup'); ?>" title="Register">Register</a>
                        <?php else: ?>
                            <a href="<?= Url::toRoute('/site/logout'); ?>" title="Sign Out" data-method='post'>Sign Out (<?= Yii::$app->user->identity->username; ?>)</a>
                        <?php endif; ?>
                        | <a href="<?= Url::toRoute('/100k'); ?>">100k for pirates</a>
                        <br/>
                    </div>
                    <div class="txt-center">
                        <div class="likely pirate">
                            <div class="twitter"
                                 data-title="Download music, movies, games, software and much more. The Pirate Bay is the world's largest bittorrent tracker.">
                                Twit
                            </div>
                            <div class="facebook"
                                 data-title="Download music, movies, games, software and much more. The Pirate Bay is the world's largest bittorrent tracker.">
                                Share
                            </div>
                            <div class="gplus"
                                 data-title="Download music, movies, games, software and much more. The Pirate Bay is the world's largest bittorrent tracker.">
                                Plus
                            </div>
                        </div>
                    </div>
                    <span class="left">Powered by <a href="http://openbay.isohunt.to"> OpenBay</a> (с) Old Pirate Bay, <?= date('Y') ?></span>
                    <span class="right">Davy Jones's locker</span>

                    <div class="clear"></div>
                </div>
            </footer>
        </div>
    </div>
    <!--[if IE]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>