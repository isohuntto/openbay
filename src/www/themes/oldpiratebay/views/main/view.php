<div id="detailsouterframe">

    <div id="detailsframe">
        <div id="title"><a href="<?= $torrent->getUrl(); ?>" class="link-textcolor vm"><?= CHtml::encode($torrent->name); ?> torrent</a></div>

        <div id="details">
            <dl class="col1">
                <dt>Type:</dt>
                <dd><a href="<?= $this->createUrl('main/search', array('iht' => $torrent->getCategoryTagId(), 'age' => 0)); ?>"><?= CHtml::encode(ucfirst($torrent->getCategoryTag())); ?></a></dd>

                <dt>Files:</dt>
                <dd><?= $torrent->files_count ?: "N/A" ; ?></dd>

                <dt>Size:</dt>
                <dd><?= Yii::app()->format->formatSize($torrent->size); ?></dd>

                <dt>Seeders:</dt>
                <dd><?= number_format($torrent->seeders, 0, '.', ' '); ?></dd>

                <dt>Leechers:</dt>
                <dd><?= number_format($torrent->leechers, 0, '.', ' '); ?></dd>

                <br>
                <dt>Info Hash:</dt><dd><?= CHtml::encode($torrent->hash); ?></dd>
            </dl>

            <br><br>
            <div style="position:relative;">
                <div class="download">
                    <a style="background-image: url('/img/icons/magnet.png');" href="<?= $torrent->getMagnetLink(); ?>" title="MAGNET LINK">&nbsp;MAGNET LINK</a>
                    <?php $downloadUrl = $torrent->getDownloadUrl();
                          if ($downloadUrl): ?>
                    <a href="<?= $downloadUrl ?>" title=".TORRENT FILE">.TORRENT FILE</a>
                    <?php endif; ?>
                </div>
                <div class="nfo">
                    <?= $torrent->getFullyPreparedDescription(); ?>
                </div>
                <br>
                <div class="download">
                    <a style="background-image: url('/img/icons/magnet.png');" href="<?= $torrent->getMagnetLink(); ?>" title="MAGNET LINK">&nbsp;MAGNET LINK</a>
                    <?php if ($downloadUrl) : ?>
                    <a href="<?= $downloadUrl ?>" title=".TORRENT FILE">.TORRENT FILE</a>
                    <?php endif; ?>
                </div>

                <div id="filelistContainer" style="display:none;">
                    <a id="show"></a>
                </div>
            </div>
        </div>
    </div>
</div>
