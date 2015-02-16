<?php

namespace frontend\modules\torrent\assets;

use Yii;
use yii\web\AssetBundle;

class ModuleAsset extends AssetBundle
{
    public $sourcePath = '@app/modules/torrent/assets/src';
    public $css = [
    ];
    public $js = [
        'js/lazy-images.js',
        'js/rating.js'
    ];
    public $depends = [
        'frontend\assets\NewopbAsset',
    ];


}