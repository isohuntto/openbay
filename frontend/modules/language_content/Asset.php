<?php

namespace frontend\modules\language_content;

use yii\web\AssetBundle;

/**
 * Module asset bundle.
 */
class Asset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@frontend/modules/language_content/assets';
    /**
     * @inheritdoc
     */
    public $js = [
        'js/jquery.tokeninput.js'
    ];
    /**
     * @var array
     */
    public $css = [
        'css/token-input-facebook.css'
    ];
    /**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\JqueryAsset'
    ];
}