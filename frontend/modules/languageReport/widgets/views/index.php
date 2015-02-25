<?php

use yii\helpers\Html;
use frontend\modules\languageReport\models\TorrentLanguage;
use frontend\modules\languageReport\models\LanguageReport;

$torrentLanguage = TorrentLanguage::findOne([$recordId]);
$languages = "";
if ($torrentLanguage) {
    $languages = $torrentLanguage->languages;
}

$showLanguageEditForm = (bool) Yii::$app->user->getId() && !LanguageReport::checkUserVote(Yii::$app->user->getId(), $recordId);
?>
<div class="languageReportWidget">
    <strong>Language:</strong>
    <span class="languageReport">
        <span id="recordLanguage" class="languageReport language"><?= $languages; ?></span>
<?php if ($showLanguageEditForm) : ?>
            <span class="languageReport reporterArea">
                <span class="reporterControl">
    <?= Html::a('Choose content language', null, ['href' => '#', 'class' => 'dashed red reportLanguage']) ?>
                </span>

                <div class="languageReport reporterForm">
                    <span class="bubble-arrow"> </span>
                    <input type="text" id="language-input" />
                    <button type="submit" id="sendReport" class="button" data-id="<?= $recordId; ?>">Send</button>
                    <button type="reset" id="cancelReport" class="button">Cancel</button>
                </div>
            </span>
<?php endif; ?>
    </span>
</div>