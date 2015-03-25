<?php

namespace frontend\modules\feed;

class FeedModule extends \yii\base\Module {

    public $controllerNamespace = 'frontend\modules\feed\controllers';

    public function init() {
        parent::init();

        \Yii::setAlias('@feed', realpath(dirname(__FILE__) . '/'));
    }

}
