<?php

namespace frontend\modules\userprofile\controllers;

use yii\web\Controller;
use Yii;
use \yii\web\ForbiddenHttpException;
use common\models\User;
use frontend\modules\torrent\models\Torrent;
use yii\data\ActiveDataProvider;
use frontend\modules\feed\models\UserFeeds;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionSubscribe() {

    }

    public function actionProfile($name) {
        if (!$name && !Yii::$app->user->getId()) {
            throw new ForbiddenHttpException();
        }

        $myProfile = false;

        if (!$name) {
            $name = Yii::$app->user->getIdentity()->username;
            $myProfile = true;
        }


        $user = User::findByUsername($name);
        $torrentsQuery = Torrent::find()->where(['user_id' => $user->id]);

        $following = false;
        if (!$myProfile && Yii::$app->user->getId() && UserFeeds::find()->where(['user_id' => Yii::$app->user->getId(), 'following_id' => $user->id])->count()) {
            $following = true;
        }

        return $this->render('profile', [
            'user' => $user,
            'torrents' => new ActiveDataProvider(['query' => $torrentsQuery]),
            'myProfile' => $myProfile,
            'following' => $following,
        ]);
    }
}
