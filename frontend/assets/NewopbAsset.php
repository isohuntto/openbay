<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;

use yii\web\AssetBundle;

class NewopbAsset extends AssetBundle
{
    public $sourcePath = '@frontend/themes/newopb/assets';
    public $css = [
        'css/styles.css',
    ];
    public $js = [
        "js/ui.js"
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\web\JqueryAsset',
    ];
}
