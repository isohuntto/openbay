<?php

namespace frontend\modules\languageReport;

use yii\base\Exception;

class LanguageReportModule extends \yii\base\Module {

    public $controllerNamespace = 'frontend\modules\languageReport\controllers';

    const EVENT_LANGUAGEREPORT_ADD = 'languageReportAdd';

    public $recordModel;
    public $salt;

    public function init() {
        parent::init();

        \Yii::setAlias('@languageReport', realpath(dirname(__FILE__) . '/'));
        if (empty($this->recordModel)) {
            throw new Exception("Unknown class recordModel");
        }
        if (empty($this->salt)) {
            throw new Exception("Salt is incorrect");
        }
    }

}
