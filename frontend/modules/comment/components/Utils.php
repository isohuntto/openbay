<?php

namespace frontend\modules\comment\components;


class Utils
{

    public static function userHash($ip)
    {
        return md5($ip . \Yii::$app->getModule('comment')->salt);
    }

} 