<?php

namespace frontend\modules\feed;

use yii\web\AssetBundle;

/**
 * Module asset bundle.
 */
class Asset extends AssetBundle {

    /**
     * @inheritdoc
     */
    public $sourcePath = '@feed/assets';

    /**
     * @inheritdoc
     */
    public $js = [
        'js/userfeed.js',
    ];

    /**
     * @inheritdoc
     */
    public $css = [
        'css/userfeed.css',
    ];

    /**
     * @inheritdoc
     */
    public $depends = [
//        'yii\bootstrap\BootstrapAsset',
        'yii\web\JqueryAsset',
    ];

}
