<?php
use frontend\assets\NewopbAsset;
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
<div class="box-header">
    <div class="space"></div>
    <div class="wrapper">
        <header>
            <a href="<?= Url::toRoute('/'); ?>" id="logo" class="block center border-none logo" title="Home&hellip;"></a>
            <?= $content; ?>
        </header>
    </div>
</div>
<div class="box-content">
    <div class="wrapper">
        <section>
            <div class="center of-account">
                <ul>
                    <li>Official account:</li>
                    <li>
                        <a href="//twitter.com/isohuntto" target="_blank"><i class="icon-20 twit"></i>@isohuntto</a>
                    </li>
                    <li>
                        <a href="//fb.com/isohuntto" target="_blank"><i class="icon-20 faceb"></i>fb.com/isohuntto</a>
                    </li>
                    <li>
                        <a href="javascript:void(0)" data-uv-lightbox="classic_widget" data-uv-mode="feedback" data-uv-primary-color="#3579BC" data-uv-link-color="#007dbf" data-uv-default-mode="support" data-uv-forum-id="279139"><i class="icon-20 idea"></i>Suggest your idea</a>
                    </li>
                    <li>
                        <a href="https://github.com/isohuntto/openbay" target="_blank"><i class="icon-20 git"></i>OpenBay at GitHub</a>
                    </li>
                    <p class="txt-center"><strong>@oldpiratebay is a <span class="red">fake account</span></strong></p>
                    <div class="clear"></div>
                </ul>
            </div>
        </section>
    </div>
</div>
<div class="box-footer">
    <div class="wrapper">
        <footer>
            <div class="center footer">
                <div class="txt-center">
                    <?php if (Yii::$app->user->isGuest) : ?>
                        <a href="<?= Url::toRoute('site/login'); ?>" title="Login">Login</a> | <a href="<?= Url::toRoute('site/signup'); ?>" title="Register">Register</a>
                    <?php else: ?>
                        <a href="<?= Url::toRoute('site/logout'); ?>" title="Sign Out" data-method='post'>Sign Out (<?= Yii::$app->user->identity->username; ?>)</a>
                    <?php endif; ?>
                    <?php/* | <a href="#">About</a> | <a href="#">Contact us</a> | <a href="#">Help</a>*/?> | <a href="<?= Url::toRoute('/100k'); ?>">100k for pirates</a>
                    <br/>
                    <?php/*<a href="#">for Developers</a> | <a href="#">for Moderators</a> | <a href="#">for Uploaders</a>*/?>
                </div>
                <div class="txt-center">
                    <div class="likely pirate">
                                <span class="social fb">
                                <!-- FACEBOOK -->
                                    <style>
                                        .fb-like {
                                            position: relative;
                                            top: -6px;

                                        }
                                        .social.tw, .social.gp {
                                            position: relative;
                                            left: 35px;
                                        }
                                    </style>
                                    <div id="fb-root"></div>
                                    <script>(function(d, s, id) {
                                            var js, fjs = d.getElementsByTagName(s)[0];
                                            if (d.getElementById(id)) return;
                                            js = d.createElement(s); js.id = id;
                                            js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.0";
                                            fjs.parentNode.insertBefore(js, fjs);
                                        }(document, 'script', 'facebook-jssdk'));</script>
                                    <div class="fb-like" data-href="http://oldpiratebay.org" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div>
                                <!-- /FACEBOOK -->
                                </span>
                                <span class="social tw">
                                    <a href="https://twitter.com/share" class="twitter-share-button" data-url="http://oldpiratebay.org/100k" data-text="Change the future of the torrenting #100kReward">Tweet</a>
                                    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
                                </span>
                                <span class="social gp">
                                    <script src="https://apis.google.com/js/platform.js" async defer></script>
                                    <div class="g-plusone" data-size="medium"></div>
                                </span>
                    </div>
                </div>
                <span class="left"> Powered by <a href="http://openbay.isohunt.to">OpenBay</a></span>
                <span class="right"> <a href="http://isohunt.to/">isoHunt</a> Group</span>
                <div class="clear"></div>
            </div>
        </footer>
    </div>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
