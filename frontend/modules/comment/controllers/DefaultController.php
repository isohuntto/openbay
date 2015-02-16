<?php

namespace frontend\modules\comment\controllers;

use common\models\torrent\Torrent;
use frontend\modules\comment\CommentModule;
use frontend\modules\comment\components\Utils;
use frontend\modules\comment\models\Comment;
use frontend\modules\comment\models\Mark;
use yii\base\Event;
use yii\web\Controller;

class DefaultController extends Controller
{

    /**
     * @var array
     */
    private $_ratingValues = [
        "up" => Mark::MARK_UP_VALUE,
        "down" => Mark::MARK_DOWN_VALUE
    ];

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * @param $id
     * @param $action
     * @return string
     */
    public function actionRating($id, $action)
    {
        $id = intval($id);
        $ratingValue = $this->_getRatingValue($action);
        if (!\Yii::$app->request->isAjax || !$id || !$ratingValue) {
            return \Yii::t("comment", "Bad request");
        }

        $userId = \Yii::$app->user->id;
        $userHash = Utils::userHash(\Yii::$app->request->userIP);
        $isGuest = \Yii::$app->user->isGuest;

        $comment = Comment::find()->where(['id' => $id])->one();
        if (!$comment) {
            return \Yii::t("comment", "Can't see any comments even through my spyglass");
        }

        if ($isGuest && $comment->user_hash == $userHash || !$isGuest && $comment->user_id == $userId) {
            return \Yii::t("comment", "Avast! Ya can't vote for yer own comment");
        }

        if ($this->_checkMark($comment->id, $isGuest, $userHash, $userId)) {
            return \Yii::t("comment", "C'mon, lad, ya've already voted on this comment");
        }

        return $this->_saveRating($comment, $ratingValue);
    }

    /**
     * @param $action
     * @return bool
     */
    private function _checkRatingAction($action)
    {
        return isset($this->_ratingValues[$action]) ? true : false;
    }

    /**
     * @param $action
     * @return int
     */
    private function _getRatingValue($action)
    {
        return $this->_checkRatingAction($action) ? $this->_ratingValues[$action] : 0;
    }

    /**
     * @param $comment
     * @param $ratingValue
     * @return string
     */
    private function _saveRating($comment, $ratingValue)
    {

        $newRatingValue = $comment->rating + $ratingValue;

        $mark = new Mark();
        $mark->comment_id = $comment->id;
        $mark->mark = $ratingValue;
        $mark->user_id = \Yii::$app->user->id;

        $comment->rating = $newRatingValue;
        $comment->setMark($mark);
        if ($comment->save()) {
            return $newRatingValue;
        }
        return \Yii::t("comment", "Arrr! Can't get yer vote. Try again later, lad!");
    }

    /**
     * @param $commentId
     * @param $isGuest
     * @param $userHash
     * @param $userId
     * @return bool
     */
    private function _checkMark($commentId, $isGuest, $userHash, $userId)
    {
        $where = ['comment_id' => $commentId];
        if ($isGuest) {
            $where['user_hash'] = $userHash;
        } else {
            $where['user_id'] = $userId;
        }

        if (Mark::find()->where($where)->count()) {
            return true;
        }
        return false;
    }

}
