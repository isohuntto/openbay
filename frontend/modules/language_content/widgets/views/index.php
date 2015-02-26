<?php
use yii\helpers\Html;

$arraylanguages = [];
foreach($languages as $language) {
    $arraylanguages[] = "{id: {$language->id}, name: '{$language->name}'}";
}
$this->registerJs("$('#language-content-form input[type=text]').tokenInput([".join(',', $arraylanguages)."], {theme: 'facebook'});");
?>
<?php if ($visible): ?>
<div class="language-content-widget">
    <?= Html::a('<b>Specify the language of content</b>', '#', ['id' => 'language-btn']); ?>
    <form id="language-content-form" class="language-content-form">
        <?= Html::hiddenInput('model_id', $modelId); ?>
        <input type="text" name="languages">
        <input type="submit" value="Select languages">
    </form>
</div>
<?php endif; ?>