<?php

namespace frontend\modules\follower\controllers;

use common\models\User;
use frontend\modules\follower\models\Follower;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\HttpException;

class DefaultController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['follow', 'unfollow', 'following', 'followers'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ]
            ]
        ];
    }

    public function actionFollowers()
    {
        $followers = Follower::find()->where(['user_id' => \Yii::$app->user->id])->all();

        $id = 0;
        if (!empty($followers)) {
            $id = [];
            foreach($followers as $item) {
                $id[] = $item->follower_user_id;
            }
        }

        $dataProvider = $this->createDataProvider($id);
        return $this->render('followers', ['dataProvider' => $dataProvider]);;
    }

    public function actionFollowing()
    {
        $following = Follower::find()->where(['follower_user_id' => \Yii::$app->user->id])->all();

        $id = 0;
        if (!empty($following)) {
            $id = [];
            foreach($following as $item) {
                $id[] = $item->user_id;
            }
        }

        $dataProvider = $this->createDataProvider($id);
        return $this->render('following', ['dataProvider' => $dataProvider]);;
    }

    public function actionFollow($username)
    {
        $user = $this->validateUsername($username);

        $follower = new Follower();
        $follower->follower_user_id = \Yii::$app->user->id;
        $follower->user_id = $user->id;
        $msg = $follower->save() ? 'Aye! Ya following this lad\'s torrents!' : 'Blimey! Something went wrong following this lad\'s torrents. Try again later.';
        \Yii::$app->session->addFlash('result', \Yii::t('follower', $msg));
        return $this->redirect('/following');
    }

    public function actionUnfollow($username)
    {
        $user = $this->validateUsername($username);

        $follower = Follower::find()->where(['user_id' => $user->id, 'follower_user_id' => \Yii::$app->user->id])->one();
        $msg = !empty($follower) && $follower->delete() ? 'Arr! Ya will not follow this lad\'s torrents anymore!' : 'Blimey! Something went wrong. Try again later.';
        \Yii::$app->session->addFlash('result', \Yii::t('follower', $msg));
        return $this->redirect('/following');
    }

    /**
     * @param $username
     * @return null|static
     * @throws HttpException
     */
    private function validateUsername($username)
    {
        $user = User::findByUsername($username);
        if (empty($user)) {
            throw new HttpException(404);
        }
        return $user;
    }

    /**
     * @param $id
     * @return ActiveDataProvider
     */
    private function createDataProvider($id)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => User::find()->where(['id' => $id]),
            'db' => \Yii::$app->db,
            'sort' => [
                'attributes' => [
                    'username' => [
                        'default' => SORT_ASC
                    ],
                ]
            ],
            'pagination' => [
                'pageSize' => 35,
            ],
        ]);

        return $dataProvider;
    }
}
