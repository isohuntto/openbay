<?php

namespace frontend\modules\rating;

class RatingModule extends \yii\base\Module
{
    const EVENT_RATING_ADD = 'ratingAdd';

    public $controllerNamespace = 'frontend\modules\rating\controllers';
    public $min = 1;
    public $max = 5;
    public $step = 1;
    public $recordModel;
    public $salt;

    public function init()
    {
        parent::init();
        \Yii::setAlias('@rating', realpath(dirname(__FILE__) . '/'));
        if (empty($this->recordModel)) {
            throw new Exception("Unknown class recordModel");
        }
        if (empty($this->salt)) {
            throw new Exception("Salt is incorrect");
        }
    }
}
