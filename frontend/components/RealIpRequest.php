<?php

namespace frontend\components;

use yii\web\Request;

class RealIpRequest extends Request {

    /**
     * Returns the real user IP address.
     * @return string real user IP address. Null is returned if the user IP address cannot be detected.
     */
    public function getUserIP()
    {
        if(isset($_SERVER['HTTP_X_REAL_IP'])) {
            return $_SERVER['HTTP_X_REAL_IP'];
        }
        return isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : null;
    }

} 