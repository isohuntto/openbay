<?php
namespace frontend\widgets\grid;

use Yii;
use yii\grid\DataColumn;
use yii\helpers\Html;

class TorrentTypeColumn extends DataColumn
{

    public function init()
    {
        parent::init();

        if (empty($this->content)) {
            $this->content = function ($model) {
                /** @var \frontend\modules\torrent\models\Torrent $model */
                return Html::a($model->getCategoryTag(), '/search?iht=' . $model->category_id, ['title' => 'Browse ' . $model->getCategoryTag() . ' torrents']);
            };
        }
    }
}