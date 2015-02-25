<?php

namespace frontend\modules\languageReport;

use yii\web\AssetBundle;

/**
 * Module asset bundle.
 */
class Asset extends AssetBundle {

    /**
     * @inheritdoc
     */
    public $sourcePath = '@languageReport/assets';

    /**
     * @inheritdoc
     */
    public $js = [
        'js/language.js',
    ];
    public $css = [
        'css/language.css',
    ];

    /**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\JqueryAsset'
    ];

}
