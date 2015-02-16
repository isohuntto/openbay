<?php

namespace frontend\modules\rating\controllers;

use frontend\modules\rating\components\RatingAddEvent;
use frontend\modules\rating\components\Utils;
use frontend\modules\rating\models\Rating;
use frontend\modules\rating\RatingModule;
use yii\base\Event;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use yii\web\Controller;

class DefaultController extends Controller
{
    /**
     * @param $id
     * @param $rating
     * @return string
     */
    public function actionSet($id, $rating)
    {
        $recordId = intval($id);
        $ratingValue = intval($rating);

        \Yii::$app->response->format = Response::FORMAT_JSON;
        if (!$this->_validationRatingValue($rating)) {
            return $this->_sendErrorResponse("Hey-hey-hey, fella, take it easy… No need to abuse our confidence.");
        }

        if (!$this->_validateRecordId($recordId)) {
            return $this->_sendErrorResponse("Hey-hey-hey, fella, take it easy… No need to abuse our confidence.");
        }
        if (!$id || !$ratingValue || !\Yii::$app->request->isAjax) {
            return $this->_sendErrorResponse("Hey-hey-hey, fella, take it easy… No need to abuse our confidence.");
        }

        if ($this->_checkVote($recordId)) {
            return $this->_sendErrorResponse("C'mon, lad, ya've already voted");
        }

        $ratingModel = new Rating();
        $ratingModel->record_id = $id;
        $ratingModel->rating = $rating;
        $ratingModel->user_id = \Yii::$app->user->id;
        if ($ratingModel->save()) {
            $this->_createRatingAddEvent($id, $rating);
            return $this->_sendSuccessResponse("We have got your vote!", ['rating'=>$rating]);
        }
        return $this->_sendErrorResponse("Arrr! Can't get yer vote. Try again later, lad!");
    }

    /**
     * @param $recordId
     * @return bool
     */
    private function _checkVote($recordId)
    {
        $where = ['record_id' => $recordId];
        if (\Yii::$app->user->isGuest) {
            $where['user_hash'] = Utils::userHash(\Yii::$app->request->userIP);
        } else {
            $where['user_id'] = \Yii::$app->user->id;
        }

        if (Rating::find()->where($where)->count()) {
            return true;
        }
        return false;
    }

    /**
     * @param $recordId
     * @return bool
     */
    private function _validateRecordId($recordId)
    {
        $recordModel = \Yii::$app->getModule("rating")->recordModel;
        if (empty($recordId) || !$recordModel::findOne($recordId)) {
            return false;
        }
        return true;
    }

    /**
     * @param $rating
     * @return bool
     */
    private function _validationRatingValue($rating)
    {
        $ratingModule = \Yii::$app->getModule("rating");
        if ($ratingModule->min <= $rating and $ratingModule->max >= $rating) {
            return true;
        }
        return false;
    }

    /**
     * @param $id
     * @param $rating
     */
    private function _createRatingAddEvent($id, $rating)
    {
        $event = new RatingAddEvent();
        $event->recordId = $id;
        $event->rating = $rating;
        $event->userId = \Yii::$app->user->id;

        Event::trigger(RatingModule::className(), RatingModule::EVENT_RATING_ADD, $event);
    }

    private function _sendErrorResponse($message, $data = [])
    {
        return $this->_sendReponse('error', $message, $data);
    }

    private function _sendSuccessResponse($message, $data = [])
    {
        return $this->_sendReponse('success', $message, $data);
    }

    private function _sendReponse($type, $message, $data)
    {
        return ArrayHelper::merge(
            [
                $type => true,
                'message' => \Yii::t("rating", $message)
            ], $data);
    }
}
