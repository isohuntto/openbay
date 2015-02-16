<?php

namespace frontend\modules\comment;

use yii\base\Exception;

class CommentModule extends \yii\base\Module
{
    const EVENT_COMMENT_ADD = 'commentAdd';

    public $controllerNamespace = 'frontend\modules\comment\controllers';

    public $recordModel;
    public $salt;
    public $reCaptchaSiteKey;
    public $reCaptchaSecretKey;

    public function init()
    {
        parent::init();
        \Yii::setAlias('@comment', realpath(dirname(__FILE__) . '/'));
        if (empty($this->recordModel)) {
            throw new Exception("Unknown class recordModel");
        }
        if (empty($this->salt)) {
            throw new Exception("Salt is incorrect");
        }
        if (empty($this->reCaptchaSiteKey)) {
            throw new Exception("Empty reCaptchaSiteKey");
        }
        if (empty($this->reCaptchaSecretKey)) {
            throw new Exception("Empty reCaptchaSecretKey");
        }
    }

}
