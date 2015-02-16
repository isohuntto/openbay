<?php
namespace frontend\widgets\grid;

use yii\grid\DataColumn;
use yii\helpers\Html;

class TorrentTitleColumn extends DataColumn
{

    public function init()
    {
        parent::init();

        if (empty($this->content)) {
            $this->content = function ($model) {
                /** @var \frontend\modules\torrent\models\Torrent $model */
                return
                Html::a($model->name, $model->getUrl()) . '
								<div class="table-mini-text">
																	' .
                Html::a('<i class="icon-12 arrow"></i>', $model->getDownloadLink(), ['title' => 'TORRENT LINK', 'class' => 'border-none v-sub']) .
                Html::a('<i class="icon-12 magnite"></i>', $model->getMagnetLink(), ['title' => 'MAGNET LINK', 'class' => 'border-none v-sub'])
                . '
									<span class="txt-min m-left-10">

									</span>
								</div>';
            };
        }
    }
}