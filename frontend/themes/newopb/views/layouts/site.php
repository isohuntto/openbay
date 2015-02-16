<?php
use yii\helpers\Url;
require(__DIR__ . '/_head.php');?>
        <div class="box-header equalizer">
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

<?php require (__DIR__ . '/_foot.php'); ?>
