<?php
namespace frontend\modules\follower\widgets;

use common\models\User;
use frontend\modules\follower\models\Follower;
use yii\base\Widget;

class FollowerWidget extends Widget
{

    public $username;
    /**
     * @return bool|void
     */
    public function init()
    {
        parent::init();
    }

    /**
     * @return string
     */
    public function run()
    {
        if (\Yii::$app->user->isGuest) {
            return '';
        }
        $user = User::findByUsername($this->username);
        if (empty($user)) {
            return "Username is incorrect";
        }
        $isFollowing = Follower::find()->where(['follower_user_id' => \Yii::$app->user->id, 'user_id' => $user->id])->count();
        return $this->render('index', [
            'isFollowing' => $isFollowing,
            'username' => $this->username
        ]);
    }

}