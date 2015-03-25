<?php

namespace frontend\modules\feed\controllers;

use Yii;
use yii\web\Controller;
use common\models\User;
use frontend\modules\feed\models\UserFeeds;
use frontend\modules\torrent\models\Torrent;
use yii\data\ActiveDataProvider;
use yii\web\Response;

class DefaultController extends Controller {

    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'allow'     => true,
                        'roles'     => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Action for following user
     * @param string $name User name to follow
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionFollow($name) {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $user = User::findByUsername($name);
        if (!$user) {
            throw new \yii\web\NotFoundHttpException();
        }

        $feed = new UserFeeds();
        $feed->user_id = Yii::$app->user->getId();
        $feed->following_id = $user->getId();
        $feed->save();

        return [
            'message' => 'Yar watching ' . $user->username . ' now!',
            'follow' => true,
        ];
    }

    /**
     * Action for unfollowing user
     * @param string $name User name to unfollow
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionUnfollow($name) {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $user = User::findByUsername($name);
        if (!$user) {
            throw new \yii\web\NotFoundHttpException();
        }

        $feed = UserFeeds::findOne(['user_id' => Yii::$app->user->getId(), 'following_id' => $user->getId()]);
        $feed->delete();

        return [
            'message' => 'Yar not watching ' . $user->username . ' anymore!',
            'follow' => false,
        ];
    }

    /**
     * User feed action
     * @return string
     */
    public function actionFeed() {
        $followingUsers = UserFeeds::find()->select('following_id')->where(['user_id' => Yii::$app->user->getId()])->column();
        $torrentsQuery = Torrent::find()->where(['user_id' => $followingUsers]);
        return $this->render('feed', [
                    'user' => Yii::$app->user->getIdentity(),
                    'torrents' => new ActiveDataProvider(['query' => $torrentsQuery]),
        ]);
    }

}
