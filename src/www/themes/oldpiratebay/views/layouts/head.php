<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?= CHtml::encode($this->pageTitle); ?></title>
    <meta name="description" content="Download music, movies, games, software and much more. The Pirate Bay is the world's largest bittorrent tracker.">
    <meta name="keywords" content="mp3, avi, bittorrent, piratebay, pirate bay, proxy, torrent, torrents, movies, music, games, applications, apps, download, upload, share, kopimi, magnets, magnet">
    <!--[if lt IE 9]>
        <link rel="stylesheet" href="/css/ie.css">
        <script src="/js/html5_for_ie.js"></script>
    <![endif]-->
    <?php
        Yii::app()->clientScript->registerPackage('base');
        Yii::app()->clientScript->registerCoreScript('jquery');
    ?>

</head>
<body>
<script>
    $(function() {
        var inputCheckBox = $('input[type=checkbox]');
        inputCheckBox.click(function() {
            inputCheckBox.attr('checked', false);
            $(this).attr('checked', true);
        });
    });
</script>
    <?php if (!$this->mainPage) : ?>
    <div id="header">
                    <form method="get" id="q" action="<?= $this->createUrl('main/search'); ?>">
                    <a href="/" class="img" style="float: left; text-decoration: none;"><img src="/img/TPB_logo_small.png" id="TPBlogo" alt="The Pirate Bay"></a>
                    <div id="srchform">
                        <div style="margin-bottom: 15px;">
                            <b><a href="/" title="Search Torrents">Search Torrents</a></b>&nbsp;&nbsp;|&nbsp;
                            <a href="<?= Yii::app()->createUrl('main/browse'); ?>" title="Browse Torrents">Browse Torrents</a>&nbsp;&nbsp;|&nbsp;
                            <a href="<?= Yii::app()->createUrl('main/recent'); ?>" title="Recent Torrent">Recent Torrents</a>
                        </div>

                        <input type="search&quot;" class="inputbox topsrch" title="Piratesearch" name="q" placeholder="search here..." value="<?=  CHtml::encode(Yii::app()->request->getParam('q'));?>">
                        <input id="searchBtn" value="" type="submit" class="submitbutton"><br>


                        <label title="All"><input name="" type="checkbox" <?php if (!Yii::app()->request->getParam('iht')) : ?>checked<?php endif; ?>>All</label>
                        <?php

                        $tags = LCategory::$categoriesTags;
                        foreach($tags as $tagId => $tag) { ?>
                            <label title="<?=$tag;?>"><input name="iht" type="checkbox" value="<?=$tagId;?>"<?php if (Yii::app()->request->getParam('iht') == $tagId) : ?>checked<?php endif; ?>><?= $tag; ?></label>
                        <?php
                        }
                        ?>
                    </div>
            </form>
    </div>
    <?php endif; ?>
