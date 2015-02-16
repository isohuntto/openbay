<?php

namespace frontend\modules\search;

use Yii;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'frontend\modules\search\controllers';

    public function init()
    {
        parent::init();

        Yii::$app->getUrlManager()->addRules([
            'browse' => $this->id . '/default/browse',
            'search' => $this->id . '/default/index',
            'search.php' => $this->id . '/default/index',
            'recent' => $this->id . '/default/recent',
        ], false);

        // custom initialization code goes here
    }
}
