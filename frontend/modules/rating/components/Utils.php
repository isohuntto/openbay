<?php

namespace frontend\modules\rating\components;


class Utils
{

    public static function userHash($ip)
    {
        return md5($ip . \Yii::$app->getModule('rating')->salt);
    }

} 