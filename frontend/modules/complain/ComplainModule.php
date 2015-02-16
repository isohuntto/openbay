<?php

namespace frontend\modules\complain;

class ComplainModule extends \yii\base\Module
{
    const EVENT_COMPLAINT_ADD = 'complaintAdd';

    public $recordModel;
    public $salt;

    public $controllerNamespace = 'frontend\modules\complain\controllers';

    public function init()
    {
        parent::init();
        \Yii::setAlias('@complain', realpath(dirname(__FILE__) . '/'));
        if (empty($this->recordModel)) {
            throw new Exception("Unknown class recordModel");
        }
        if (empty($this->salt)) {
            throw new Exception("Salt is incorrect");
        }
    }
}
