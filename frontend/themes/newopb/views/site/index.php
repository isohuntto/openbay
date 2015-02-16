<?php
use frontend\modules\tag\models\Category;
use yii\helpers\Url;
use yii\helpers\Html;
?>

<div class="txt-center torrents-menu">
    <a href="<?= Url::toRoute('/'); ?>" class="disabled">Search Torrents</a>
    <a href="<?= Url::toRoute('/browse'); ?>">Browse Torrents</a>
    <a href="<?= Url::toRoute('/recent'); ?>">Recent Torrents</a>
</div>
<form name="q" method="get" action="<?= Url::toRoute('/search'); ?>">
    <div class="txt-center">
        <input name="q" type="search" class="search" placeholder="Pirate Search…" title="Pirate Search" autofocus="true" required="true"/>
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
        foreach($tags as $tagId => $tag) : ?>
        <li>
            <label title="<?= Html::encode($tag);?>">
                <input name="iht" type="checkbox" value="<?=$tagId;?>"><?= Html::encode($tag); ?>
            </label>
        </li>
        <?php endforeach; ?>

        <div class="clear"></div>
    </ul>
    <div class="txt-center search-button">
        <input type="submit" title="Pirate Search" value="Pirate Search" id="searchBtn" class="button"/>
        <input type="submit" title="I'm Feeling Lucky" value="I'm Feeling Lucky" name="lucky" id="luckyBtn" class="button"/>
    </div>
</form>
<div class="txt-center last-news center">
    <h3 class="black bold">LATEST NEWS</h3>
    <p>
        Hi guys!<br/>
        We want to make a torrent site of your dreams. The one for users not for AD sellers. You can present your ideas, launch our own torrent site or get in to competition with $100000 prize.
        Let's make an revolutionary torrent site together!
    </p>
    <a href="<?= Url::toRoute('/100k');?>">How to earn $100000</a>
</div>
