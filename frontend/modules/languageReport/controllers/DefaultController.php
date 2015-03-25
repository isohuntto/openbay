<?php

namespace frontend\modules\languageReport\controllers;

use yii\web\Controller;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use frontend\modules\languageReport\models\Language;
use frontend\modules\languageReport\models\LanguageReport;
use frontend\modules\languageReport\models\TorrentLanguage;
use frontend\modules\languageReport\components\LanguageReportAddEvent;
use frontend\modules\languageReport\LanguageReportModule;
use yii\base\Event;

class DefaultController extends Controller {

    /**
     * @inheritdoc
     */
    public function beforeAction($action) {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        if (!\Yii::$app->request->isAjax) {
            return false;
        }
        return parent::beforeAction($action);
    }

    /**
     * Gets the list of already reported languages
     * @return String[]
     */
    public function actionLanguages() {
        return Language::find()->select('language')->createCommand()->queryColumn();
    }

    /**
     * Report handling action.
     * @param int $id
     * @param string $language Comma separated list of languages
     * @return array
     */
    public function actionReport($id, $language) {
        $recordId = intval($id);
        $languages = explode(',', $language);
        $languages = array_map('trim', $languages);
        $languages = array_map('strtolower', $languages);

        $result = $this->_validate($recordId, $languages);
        if ($result !== true) {
            return $result;
        }
        return $this->_saveReport($recordId, $languages);
    }

    /**
     * @param $recordId
     * @param $languages
     * @return array
     */
    private function _saveReport($recordId, $languages) {
        $transaction = \Yii::$app->db->beginTransaction();
        $recordLanguages = "";
        $result = Language::saveLanguages($languages);

        if ($result) {
            $recordLanguages = TorrentLanguage::defineLanguages($recordId, $languages);

            if ($recordLanguages === false) {
                $result = false;
            }

            if (!TorrentLanguage::saveLanguages($recordId, $recordLanguages)) {
                $result = false;
            }

            $this->_createLanguageReportAddEvent($recordId, $recordLanguages);
        }

        if ($result) {
            $lang = new LanguageReport();
            $lang->record_id = $recordId;
            $lang->user_id = \Yii::$app->user->id;
            $lang->language = join(',', $languages);
            if (!$lang->save()) {
                $result = false;
            }
        }

        if ($result) {
            $transaction->commit();
            return $this->_sendSuccessResponse("We have got your vote!", ['languages' => join(', ', $recordLanguages)]);
        }

        $transaction->rollback();
        return $this->_sendErrorResponse("Arrr! Can't get yer vote. Try again later, lad!");
    }

    /**
     * @param $recordId
     * @param $languages
     * @return bool|string
     */
    private function _validate($recordId, $languages) {
        if (!\Yii::$app->user->getId()) {
            return $this->_sendErrorResponse("C'mon, lad, ya've got to authorize");
        }
        if (!count($languages)) {
            return $this->_sendErrorResponse("Report can\'t be blank! It\'s like grog without rum!");
        }
        if (!$this->_validateRecordId($recordId)) {
            return $this->_sendErrorResponse("Hey-hey-hey, fella, take it easy… No need to abuse our confidence.");
        }
        if (!$recordId || !\Yii::$app->request->isAjax) {
            return $this->_sendErrorResponse("Hey-hey-hey, fella, take it easy… No need to abuse our confidence.");
        }
        if ($this->_checkVote($recordId)) {
            return $this->_sendErrorResponse("C'mon, lad, ya've already voted");
        }
        return true;
    }

    /**
     * @param $recordId
     * @return bool
     */
    private function _validateRecordId($recordId) {
        $recordModel = \Yii::$app->getModule("complain")->recordModel;
        if (empty($recordId) || !$recordModel::findOne($recordId)) {
            return false;
        }
        return true;
    }

    /**
     * @param $recordId
     * @return bool
     */
    private function _checkVote($recordId) {
        return LanguageReport::checkUserVote(\Yii::$app->user->id, $recordId);
    }

    private function _sendErrorResponse($message, $data = []) {
        return $this->_sendResponse('error', $message, $data);
    }

    private function _sendSuccessResponse($message, $data = []) {
        return $this->_sendResponse('success', $message, $data);
    }

    private function _sendResponse($type, $message, $data) {
        return ArrayHelper::merge(
                        [
                    $type => true,
                    'message' => \Yii::t("complain", $message)
                        ], $data);
    }

    /**
     * @param $recordId int
     * @param $languages string
     */
    private function _createLanguageReportAddEvent($recordId, $languages) {
        $event = new LanguageReportAddEvent();
        $event->recordId = $recordId;
        $event->languages = $languages;
        $event->userId = \Yii::$app->user->id;

        Event::trigger(LanguageReportModule::className(), LanguageReportModule::EVENT_LANGUAGEREPORT_ADD, $event);
    }

}
