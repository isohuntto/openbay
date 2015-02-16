<?php

namespace frontend\components;

use frontend\modules\comment\CommentModule;
use frontend\modules\complain\ComplainModule;
use frontend\modules\complain\models\Complaint;
use frontend\modules\rating\RatingModule;
use frontend\modules\torrent\models\Torrent;
use \yii\base\Component;
use \yii\base\BootstrapInterface;
use yii\base\Event;

class HandlerEvent extends Component implements BootstrapInterface
{

    public function bootstrap($app)
    {
        Event::on(RatingModule::className(), RatingModule::EVENT_RATING_ADD, function ($event) {
            $torrent = \Yii::$app->db->cache(function($db) use ($event) {
                return Torrent::findOne($event->recordId);
            });
            $torrent->rating_avg = ($torrent->rating_votes * $torrent->rating_avg + $event->rating) / ($torrent->rating_votes + 1);
            $torrent->rating_votes = $torrent->rating_votes + 1;
            $torrent->save(false);
        });

        Event::on(ComplainModule::className(), ComplainModule::EVENT_COMPLAINT_ADD, function ($event) {
            if ($event->total >= \Yii::$app->params['numberComplaintsToHide'] && ($event->type === Complaint::TYPE_FAKE || $event->type === Complaint::TYPE_VIRUS)) {
                $torrent = \Yii::$app->db->cache(function($db) use ($event) {
                    return Torrent::findOne($event->recordId);
                });
                $torrent->visible_status = Torrent::VISIBLE_STATUS_DIRECT;
                $torrent->save(false);
            }
        });

        Event::on(CommentModule::className(), CommentModule::EVENT_COMMENT_ADD, function($event) {
            $torrent = \Yii::$app->db->cache(function($db) use ($event) {
                return Torrent::findOne($event->recordId);
            });
            $torrent->comments_count = $torrent->comments_count + 1;
            $torrent->save(false);
        });
    }

}