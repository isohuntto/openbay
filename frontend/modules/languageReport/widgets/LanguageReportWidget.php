<?php

namespace frontend\modules\languageReport\widgets;

use frontend\modules\languageReport\Asset;
use frontend\modules\languageReport\TagInputAsset;
use frontend\modules\languageReport\TypeAheadAsset;
use yii\base\Widget;

class LanguageReportWidget extends Widget {

    public $recordId;
    private $_initError = false;

    /**
     * @return bool|void
     */
    public function init() {
        parent::init();
        if (!$this->_validateRecordId()) {
            $this->_initError = true;
        }
        $this->_registerClientScript();
    }

    /**
     * @return string
     */
    public function run() {
        if (!$this->_initError) {
            return $this->render('index', [
                        'recordId' => $this->recordId,
            ]);
        }
        return \Yii::t("languageReport", "Unknown recordId");
    }

    /**
     * @return bool
     */
    private function _validateRecordId() {
        $recordModel = \Yii::$app->getModule("languageReport")->recordModel;
        if (empty($this->recordId) || !$recordModel::findOne($this->recordId)) {
            return false;
        }
        return true;
    }

    /**
     * Register widget client scripts.
     */
    private function _registerClientScript() {
        $view = $this->getView();
        Asset::register($view);
        TagInputAsset::register($view);
        TypeAheadAsset::register($view);
    }

}
