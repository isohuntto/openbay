<?php

namespace frontend\modules\complain\controllers;

use frontend\modules\complain\ComplainModule;
use frontend\modules\complain\components\ComplaintAddEvent;
use frontend\modules\complain\components\Utils;
use frontend\modules\complain\models\Complaint;
use yii\base\Event;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\Response;

class DefaultController extends Controller
{
    /**
     * @param $id
     * @return string
     */
    public function actionFake($id)
    {
        return $this->_handleComplaint($id, Complaint::TYPE_FAKE);
    }

    /**
     * @param $id
     * @return bool|string
     */
    public function actionVirus($id)
    {
        return $this->_handleComplaint($id, Complaint::TYPE_VIRUS);
    }

    /**
     * @param $id
     * @return bool|string
     */
    public function actionIncorrectDescription($id)
    {
        return $this->_handleComplaint($id, Complaint::TYPE_INCORRECT_DESCRIPTION);
    }

    /**
     * @param $id
     * @param $type
     * @return bool|string
     */
    private function _handleComplaint($id, $type)
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $recordId = intval($id);

        $result = $this->_validate($recordId, $type);
        if ($result !== true) {
            return $result;
        }
        return $this->_saveComplaint($recordId, $type);
    }

    /**
     * @param $recordId
     * @param $type
     * @return bool|string
     */
    private function _validate($recordId, $type)
    {
        if (!$this->_validateRecordId($recordId)) {
            return $this->_sendErrorResponse("Hey-hey-hey, fella, take it easy… No need to abuse our confidence.");
        }
        if (!$recordId || !\Yii::$app->request->isAjax) {
            return $this->_sendErrorResponse("Hey-hey-hey, fella, take it easy… No need to abuse our confidence.");
        }
        if ($this->_checkVote($recordId, $type)) {
            return $this->_sendErrorResponse("C'mon, lad, ya've already voted");
        }
        return true;
    }

    /**
     * @param $recordId
     * @param $type
     * @return string
     */
    private function _saveComplaint($recordId, $type)
    {
        $complaint = new Complaint();
        $complaint->record_id = $recordId;
        $complaint->user_id = \Yii::$app->user->id;
        $complaint->type = $type;
        if ($complaint->save()) {
            $this->_createComplaintAddEvent($recordId, $type);
            return $this->_sendSuccessResponse("We have got your vote!");
        }
        return $this->_sendErrorResponse("Arrr! Can't get yer vote. Try again later, lad!");
    }

    /**
     * @param $recordId
     * @param $type
     * @return bool
     */
    private function _checkVote($recordId, $type)
    {
        $where = [
            'record_id' => $recordId,
            'type' => $type
        ];
        if (\Yii::$app->user->isGuest) {
            $where['user_hash'] = Utils::userHash(\Yii::$app->request->userIP);
        } else {
            $where['user_id'] = \Yii::$app->user->id;
        }

        if (Complaint::find()->where($where)->count()) {
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
        $recordModel = \Yii::$app->getModule("complain")->recordModel;
        if (empty($recordId) || !$recordModel::findOne($recordId)) {
            return false;
        }
        return true;
    }

    /**
     * @param $recordId
     * @param $type
     */
    private function _createComplaintAddEvent($recordId, $type)
    {
        $event = new ComplaintAddEvent();
        $event->recordId = $recordId;
        $event->type = $type;
        $event->userId = \Yii::$app->user->id;
        $event->total = Complaint::find()->where(['record_id' => $recordId, 'type'=>$type])->count();

        Event::trigger(ComplainModule::className(), ComplainModule::EVENT_COMPLAINT_ADD, $event);
    }


    private function _sendErrorResponse($message, $data = [])
    {
        return $this->_sendResponse('error', $message, $data);
    }

    private function _sendSuccessResponse($message, $data = [])
    {
        return $this->_sendResponse('success', $message, $data);
    }

    private function _sendResponse($type, $message, $data)
    {
        return ArrayHelper::merge(
            [
                $type => true,
                'message' => \Yii::t("complain", $message)
            ], $data);
    }
}
