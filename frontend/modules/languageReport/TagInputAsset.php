<?php

namespace frontend\modules\languageReport;

use yii\web\AssetBundle;

/**
 * Module asset bundle.
 */
class TagInputAsset extends AssetBundle {

    /**
     * @inheritdoc
     */
    public $sourcePath = '@bower/';

    /**
     * @inheritdoc
     */
    public $js = [
//        'typeahead.js/dist/typeahead.bundle.js',
        'tagsinput/dist/bootstrap-tagsinput.js',
    ];
    public $css = [
        'tagsinput/dist/bootstrap-tagsinput.css',
    ];

    /**
     * @inheritdoc
     */
    public $depends = [
//        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];

}
