<?php
namespace frontend\widgets\grid;

use Yii;
use yii\grid\DataColumn;

class TorrentAgeColumn extends DataColumn
{
    public function init()
    {
        parent::init();

        if (empty($this->content)) {
            $this->content = function ($model) {
                /** @var \frontend\modules\torrent\models\Torrent $model */
                return Yii::$app->formatter->asRelativeTime($model->created_at);
            };
        }
    }
}