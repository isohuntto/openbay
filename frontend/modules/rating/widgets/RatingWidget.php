<?php
namespace frontend\modules\rating\widgets;

use frontend\modules\rating\Asset;
use frontend\modules\rating\models\RatingStat;
use yii\base\Widget;

class RatingWidget extends Widget
{
    public $recordId;

    private $_ratingModule;
    private $_initError = false;

    /**
     * @return bool|void
     */
    public function init()
    {
        parent::init();
        $this->_ratingModule = \Yii::$app->getModule("rating");
        if (!$this->_validateRecordId()) {
            $this->_initError = true;
            return;
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
                'min' => $this->_ratingModule->min,
                'max' => $this->_ratingModule->max,
                'step' => $this->_ratingModule->step,
                'recordId' => $this->recordId,
                'ratingStats' => RatingStat::findAll(['record_id' => $this->recordId])
            ]);
        }
        return \Yii::t("rating", "Unknown recordId");
    }

    /**
     * @return bool
     */
    private function _validateRecordId()
    {
        $recordModel = $this->_ratingModule->recordModel;
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