<?php

namespace frontend\modules\search\filters;

use Yii;
use yii\base\ActionFilter;

class SearchRequestFilter extends ActionFilter
{

    public function beforeAction($action) {
        $uri = Yii::$app->request->getUrl();
        if (preg_match('#q=([^&]+)#', $uri, $matches)) {
            $q = $matches[1];
            $filtered = preg_replace('#(\s|%20)#ui', '+', $q);
            $filtered = preg_replace('#%2B#ui', '+', $filtered);
            $filtered = preg_replace('#\+{2,}#', '+', $filtered);
            $filtered = trim($filtered, '+');
            $filteredUri = str_replace($q, $filtered, $uri);
            if ($uri !== $filteredUri) {
                $action->controller->redirect($filteredUri);
            }
        }
        return true;
    }

}
