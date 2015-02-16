<?php

namespace frontend\modules\search\filters;

use Yii;
use yii\base\ActionFilter;
use frontend\modules\torrent\models\Torrent;

class HashFilter extends ActionFilter
{

    public function beforeAction($action) {
        $query = Yii::$app->request->getQueryParam('q');

        $queryLength = mb_strlen($query, 'UTF-8');

        if (40 == $queryLength && preg_match('#^[0-9a-f]{40}$#i', $query)) {
            if ($torrent = Torrent::find()->where(['hash' => $query])->one()) {
                $action->controller->redirect($torrent->getUrl());
            }
        }

        return parent::beforeAction($action);
    }

}
