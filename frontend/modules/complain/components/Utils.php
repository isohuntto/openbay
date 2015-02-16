<?php

namespace frontend\modules\complain\components;


class Utils
{

    public static function userHash($ip)
    {
        return md5($ip . \Yii::$app->getModule('complain')->salt);
    }

} 