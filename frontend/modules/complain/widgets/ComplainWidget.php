<?php
namespace frontend\modules\complain\widgets;

use frontend\modules\complain\Asset;
use yii\base\Widget;

class ComplainWidget extends Widget
{
    public $recordId;

    private $_initError = false;

    /**
     * @return bool|void
     */
    public function init()
    {
        parent::init();
        if (!$this->_validateRecordId()) {
            $this->_initError = true;
        }
        $this->_registerClientScript();
    }

    /**
     * @return string
     */
    public function run()
    {
        if (!$this->_initError) {
            return $this->render('index', [
                'recordId' => $this->recordId,
            ]);
        }
        return \Yii::t("complain", "Unknown recordId");
    }

    /**
     * @return bool
     */
    private function _validateRecordId()
    {
        $recordModel = \Yii::$app->getModule("complain")->recordModel;
        if (empty($this->recordId) || !$recordModel::findOne($this->recordId)) {
            return false;
        }
        return true;
    }

    /**
     * Register widget client scripts.
     */
    private function _registerClientScript()
    {
        $view = $this->getView();
        Asset::register($view);
    }

}