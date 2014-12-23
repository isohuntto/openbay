<div id="fp">
        <h1><a href="/" title="The Pirate Bay"><span>The Pirate Bay</span></a>

</h1>

       <nav id="navlinks">
           <strong>Search Torrents</strong> |
           <a href="<?= Yii::app()->createUrl('main/browse'); ?>" title="Browse Torrents">Browse Torrents</a> |
           <a href="<?= Yii::app()->createUrl('main/browse'); ?>" title="Recent Torrents">Recent Torrents</a>
       </nav>
       <form name="q" method="get" action="<?= $this->createUrl('main/search'); ?>">
           <p id="inp">
               <input name="q" type="search" title="Pirate Search" placeholder="Pirate Search" autofocus required>
           </p>
           <p id="chb">
                <label title="All"><input name="" type="checkbox" checked>All</label>
                <?php

                $tags = LCategory::$categoriesTags;
                foreach($tags as $tagId => $tag) { ?>
                    <label title="<?= CHtml::encode($tag);?>"><input name="iht" type="checkbox" value="<?=$tagId;?>"><?= CHtml::encode($tag); ?></label>
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
<div>Powered by <a href="http://isohunt.to">isohunt.to</a></div>
