<?php

namespace frontend\modules\comment\widgets;

use frontend\modules\comment\Asset;
use frontend\modules\comment\CommentModule;
use frontend\modules\comment\components\CommentAddEvent;
use frontend\modules\comment\models\Comment;
use yii\base\Event;
use yii\base\Widget;

class CommentWidget extends Widget
{
    public $recordId;
    public $minRating = -5;
    public $defaultComment = "Comment removed";

    private $_comments = "";
    private $_model;
    private $_initError = false;

    public function init()
    {
        parent::init();
        if (!$this->_validateRecordId()) {
            $this->_initError = true;
            return false;
        }
        $this->_loadModel();
        $this->_getComments();
        $this->_registerClientScript();
    }

    public function run()
    {
        if (!$this->_initError) {
            return $this->render("index", [
                'comments' => $this->_comments,
                'minRating' => $this->minRating,
                'defaultComment' => \Yii::t("comment", $this->_getDefaultComment()),
                'model' => $this->_model
            ]);
        }
        return \Yii::t("comment", "Can't see any comments even through my spyglass");
    }

    /**
     * @return bool
     */
    private function _validateRecordId()
    {
        $recordModel = \Yii::$app->getModule("comment")->recordModel;
        if (empty($this->recordId) || !$recordModel::findOne($this->recordId)) {
            return false;
        }
        return true;
    }

    /**
     *
     */
    private function _getComments()
    {
        $comments = Comment::find()->where(['record_id' => $this->recordId])->orderBy("lft asc")->all();
        if ($comments) {
            $this->_comments = $comments;
        }
    }

    /**
     *
     */
    private function _loadModel()
    {
        if (\Yii::$app->user->isGuest) {
            $scenario = 'add-guest';
            $author = 'Anonymous';
        } else {
            $scenario = 'add-user';
            $author = \Yii::$app->user->identity->username;
        }

        $model = new Comment(['scenario' => $scenario]);
        $model->author = $author;
        $model->user_id = \Yii::$app->user->id;

        $model->record_id = $this->recordId;
        $this->_model = $model;
        if (!$this->_model->load(\Yii::$app->request->post())) {
            return;
        }

        $parentComment = $this->_model->parentId ? Comment::findOne($this->_model->parentId) : Comment::find()->roots()->one();
        if (!$this->_model->appendTo($parentComment)) {
            \Yii::$app->session->setFlash("error", \Yii::t("comment", "Yer comment fell overboard :( Add it again, lad!"));
            return;
        }

        $this->_createCommentAddEvent();

        \Yii::$app->session->setFlash("success", \Yii::t("comment", "Aye! Yer comment is mine!"));
        \Yii::$app->response->redirect("");
        \Yii::$app->end();
    }

    /**
     * Register widget client scripts.
     */
    private function _registerClientScript()
    {
        $view = $this->getView();
        Asset::register($view);
    }

    /**
     * @return string
     */
    private function _getDefaultComment()
    {
        if (is_array($this->defaultComment)) {
            shuffle($this->defaultComment);
            return $this->defaultComment[0];
        } else {
            return $this->defaultComment;
        }
    }

    /**
     *
     */
    private function _createCommentAddEvent()
    {
        $event = new CommentAddEvent();
        $event->recordId = $this->_model->record_id;
        $event->userId = $this->_model->user_id;
        Event::trigger(CommentModule::className(), CommentModule::EVENT_COMMENT_ADD, $event);
    }

}