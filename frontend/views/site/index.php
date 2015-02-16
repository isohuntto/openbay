<?php
use yii\helpers\Html;
use frontend\modules\tag\models\Category;
use yii\helpers\Url;
/* @var $this yii\web\View */
$this->title = "Main";
$this->params['mainPage'] = true;
?>
<div id="fp">
    <div style="position: relative; width: 1000px; margin: 0 auto;">
        <h1><a href="/" title="The Pirate Bay"><span>The Pirate Bay</span></a></h1>
        <div style="
            position: absolute;  right: 0;  top: 30px;  width: 300px;  height: 60px;
            text-align: left;
            font-size: 14px !important;
                color: #2D547B;
        ">
        <img src="/img/off_accs.png"><br>
        <a target="_blank" style="    background: transparent;
            margin: 0;
            width: auto;
            height: auto;" href="//twitter.com/isohuntto"><img src="/img/tw.png" style="
            display: inline-block;
            vertical-align: middle;
        "> @isohuntto<br></a>
        <a target="_blank" style="    background: transparent;
            margin: 0;
            width: auto;
            height: auto;" href="//fb.com/isohuntto"><img src="/img/fb.png" style="
            display: inline-block;
            vertical-align: middle;
        "> fb.com/isohuntto<br><br> </a><b>@oldpiratebay is a <font color="aa0101">fake account</font></b><br>
        </div>
        <div style="clear: both;"></div>
    </div>


<?php /*
        <div class="idea_description">
            <p>We want to give you an opportunity to speak your mind, determine needs and be active participants in the evolution of the oldpiratebay.org.
            A lot of requests were received for a wide range of features but we want to emphasize the development process
            so we call to the colors of this enormous and devoted community to create new features requests and code those features.</p>

            <p><strong>We call out torrent community to join in to develop and enhance this engine to create a modern and advanced website that
            every user all around the world would want to use. And to make it possible for those of you who want to run your own copy
            of The Pirate Bay.</strong></p>
        </div>

    <div id="codelinks" style="width: 1000px; margin: 30px auto 30px;">
        <div style="width: 50%; float: left;">
            <a href="javascript:void(0)" data-uv-lightbox="classic_widget" data-uv-mode="feedback" data-uv-primary-color="#3579BC" data-uv-link-color="#007dbf" data-uv-default-mode="support" data-uv-forum-id="279139">Suggest your idea</a>
        </div>
        <div style="width: 50%; float: right;">
            <a href="https://github.com/isohuntto/openbay" target="_blank">#CodeOpenBay</a>
        </div>
        <div style="clear: both;"></div>
    </div>
*/?>

    <div style="padding: 50px 0;">
        <a href='/100k' style="text-decoration: none; border-bottom: 0;margin: 30px 0;"><img src="/img/title_100k.png"/></a>

        <div style="text-align: right; width: 900px; margin: 0 auto;">
        <a href="/100k" style="font-size: 20px;">More details</a>
        </div>
    </div>

       <nav id="navlinks">
           <strong>Search Torrents</strong> |
           <a href="<?= Url::toRoute('/browse') ?>" title="Browse Torrents">Browse Torrents</a> |
           <a href="<?= Url::toRoute('/recent'); ?>" title="Recent Torrents">Recent Torrents</a>
       </nav>
       <form name="q" method="get" action="<?= Url::toRoute('/search'); ?>">
           <p id="inp">
               <input name="q" type="search" title="Pirate Search" placeholder="Pirate Search" autofocus required>
           </p>
           <p id="chb">
                <label title="All"><input name="" type="checkbox" checked>All</label>
                <?php

                $tags = Category::$categoriesTags;
                foreach($tags as $tagId => $tag) { ?>
                    <label title="<?= Html::encode($tag);?>"><input name="iht" type="checkbox" value="<?=$tagId;?>"><?= Html::encode($tag); ?></label>
                <?php
                }
                ?>
           </p>
           <p id="subm">
               <input type="submit" title="Pirate Search" value="" accesskey="s" id="searchBtn"><font color="white">...........................</font>
               <input type="submit" title="I'm Feeling Lucky" name="lucky" value="" id="luckyBtn">
           </p>
       </form>
       </br></br>
    </div>
</br></br>
<?php /*
<div id="twitter-container" style="text-align: left; width: 1000px; margin: 0 auto;padding-bottom: 30px;">
    <style>
        #twitter-container iframe {
            width: 1000px !important;
        }
    </style>
    <img src="/img/codeopenbay.png"><br/>
    <a class="twitter-timeline" href="https://twitter.com/search?q=oldpiratebay" data-widget-id="543671521412390912">Tweets about oldpiratebay</a>
    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");

    </script>
</div>
*/?>
<span class="social">
<a href="https://twitter.com/share" class="twitter-share-button" data-url="http://oldpiratebay.org/" data-text="The Pirate Bay Search - revived by IsoHunt #longliveTPB">Tweet</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
</span>
<span class="social">

<script src="https://apis.google.com/js/platform.js" async defer></script>
<div class="g-plusone" data-size="medium"></div>

</span>

<div style="margin-top: 30px;">Powered by <a href="http://isohunt.to">isohunt.to</a></div>
