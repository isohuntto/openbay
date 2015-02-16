<?php

namespace frontend\modules\comment;

use yii\web\AssetBundle;

/**
 * Module asset bundle.
 */
class Asset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@comment/assets';
    /**
     * @inheritdoc
     */
    public $js = [
        'js/comments.js'
    ];
    /**
     * @var array
     */
    public $css = [
        'css/comments.css'
    ];
    /**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\JqueryAsset'
    ];
}