<?php
function _copyGET() {
    $queryParams = $_GET;
    if (isset($queryParams['popular'])) {
        unset($queryParams['popular']);
    }
    return $queryParams;
}

$paramQ = Yii::app()->request->getParam('q');
?>
<div class="p bg-white mb">
    <?php if ($paramQ): ?>
        <h1 class="mt0">Search results for &laquo;<?= CHtml::encode($paramQ) ?>&raquo;</h1>
    <?php else: ?>
            <a href="<?= Yii::app()->createUrl('rss/index', array('tag' => $categoryTag)); ?>" target="_blank" class="pull-right rss-icon"></a>
            <h1 class="mt0"><?= ucfirst(CHtml::encode($categoryTag)); ?> Torrents</h1>
    <?php endif; ?>
    <div class="<?= !$paramQ ? 'category-margin' : '' ?>">
    <a href="<?= Yii::app()->createUrl('main/browse'); ?>" class="btn btn-default mr-h4" title="Browse all torrents by category">Browse All Torrents</a>
    </div>

<?php
$this->widget('application.widgets.grid.TorrentGridWidget', array(
    'id' => 'serps',
    'ajaxUpdate' => false,
    'dataProvider' => $torrents,
    'template' => '{items}{pager}',
    'pagerCssClass' => 'pagination',
    'showTableOnEmpty' => Yii::app()->request->getParam('ihq', false),
    'pager' => array(
        'class' => 'application.widgets.pagers.Pager',
        'firstPageLabel' => '««',
        'lastPageLabel' => '»»',
        'nextPageLabel' => '»',
        'prevPageLabel' => '«',
    ),
    'renderKeys' => false,
    'initScripts' => false
)); ?>

<script>
   $(function(){
       $('select').change(function() {
           $('#filter-form').submit();
       });
   });
</script>
