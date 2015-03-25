<?php

namespace frontend\modules\feed\widgets;

use frontend\modules\feed\Asset;
use yii\base\Widget;
use frontend\modules\feed\models\UserFeeds;

class FollowWidget extends Widget {

    public $user;

    /**
     * @return bool|void
     */
    public function init() {
        parent::init();
        $this->_registerClientScript();
    }

    /**
     * @return string
     */
    public function run() {
        $authed = \Yii::$app->user->getId();
        $myProfile = $authed && (\Yii::$app->user->getId() == $this->user->getId());
        $following = false;
        if (!$myProfile && $authed && UserFeeds::find()->where(['user_id' => \Yii::$app->user->getId(), 'following_id' => $this->user->getId()])->count()) {
            $following = true;
        }

        return $this->render('index', [
                    'authed' => $authed,
                    'myProfile' => $myProfile,
                    'following' => $following,
                    'user' => $this->user,
                ]);
    }

    /**
     * Register widget client scripts.
     */
    private function _registerClientScript() {
        \Yii::$app->getModule('feed');
        $view = $this->getView();
        Asset::register($view);
    }

}
