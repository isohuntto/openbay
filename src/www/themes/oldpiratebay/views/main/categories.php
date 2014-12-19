<div class="browse-cats short-query">
    <?php foreach ($tags as $tag) {
        $tagLower = mb_strtolower($tag, Yii::app()->charset);
        $tagId = array_search($tag, LCategory::$categoriesTags);
    ?>
    <div class="bg-white mb p">
        <h3 class="mt0"><a href="<?= $this->createUrl('main/search', array('iht' => $tagId, 'age' => 0)); ?>"><?= CHtml::encode($tag); ?> Torrents</a></h3>
        <small>
            <a href="<?= $this->createUrl('main/search', array('iht' => $tagId, 'ihs' => 1, 'age' => 1)); ?>">For last day only</a>
        </small>
        <?php if (isset($torrents[$tagLower])) {
            $this->widget('application.widgets.grid.TorrentGridWidget', array(
                'id' => 'serps' . $tag,
                'ajaxUpdate' => false,
                'dataProvider' => new CArrayDataProvider($torrents[$tagLower]),
                'template' => '{items}',
                'initScripts' => false,
                'tag' => $tagLower,
                'renderKeys' => false
            ));
        } ?>
    </div>
    <?php } ?>
</div>
