<div class="p bg-white">
    <h1 class="mt0">Latest Torrents</h1>
        <div class="<?= !Yii::app()->request->getParam('ihq') ? 'category-margin' : '' ?>">
            <a href="<?= Yii::app()->createUrl('main/browse'); ?>" title="Browse all torrents by category" class=" btn btn-default mtn-sm mr-h4">Browse All Torrents</a>
        </div>
<?php
$this->widget('application.widgets.grid.TorrentGridWidget', array(
    'id' => 'serps',
    'ajaxUpdate' => false,
    'dataProvider' => $torrents,
    'template' => '{items}{pager}',
    'pagerCssClass' => 'pagination',
    'pager' => array(
        'class' => 'application.widgets.pagers.Pager',
        'firstPageLabel' => '««',
        'lastPageLabel' => '»»',
        'nextPageLabel' => '»',
        'prevPageLabel' => '«',
    ),
    'initScripts' => false,
    'renderKeys' => false
)); ?>
</div>