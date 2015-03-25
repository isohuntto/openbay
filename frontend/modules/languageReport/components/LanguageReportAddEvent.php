<?php

namespace frontend\modules\languageReport\components;

use yii\base\Event;

/**
 * Event for handling language report
 */
class LanguageReportAddEvent extends Event {

    public $recordId;
    public $userId;
    public $languages;

}
