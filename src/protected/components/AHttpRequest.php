<?php

class AHttpRequest extends CHttpRequest
{

    /**
     * IP address of the current user
     *
     * @var boolean
     */

    private $ipAddress = null;

    public $countryCode = '';

    public $isMac = false;

    public function init()
    {
        parent::init();
    }

    /**
     * Returns the user IP address.
     *
     * @see http://stackoverflow.com/a/916157
     * @return string user IP address
     */
    public function getUserHostAddress()
    {
        if (! is_null($this->$ipAddress)) {
            return $this->$ipAddress;
        }
        foreach (array(
            'HTTP_X_REAL_IP',
            'HTTP_CLIENT_IP',
            'HTTP_X_FORWARDED_FOR',
            'HTTP_X_FORWARDED',
            'HTTP_X_CLUSTER_CLIENT_IP',
            'HTTP_FORWARDED_FOR',
            'HTTP_FORWARDED',
            'REMOTE_ADDR'
        ) as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    $ip = trim($ip);
                    // Allow only IPv4 address, Deny reserved addresses, Deny private addresses
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                        return ($this->$ipAddress = $ip);
                    }
                }
            }
        }
        // NOTE: or use something like this 127.0.0.2
        return ($this->$ipAddress = '0.0.0.0');
    }

    public function getCountryCode()
    {
        if (empty($this->countryCode) && ! YII_DEBUG) {
            if (empty(Yii::app()->request->cookies['country_code'])) {
                $this->countryCode = geoip_country_code_by_name($this->getUserHostAddress());
                Yii::app()->request->cookies['country_code'] = new CHttpCookie('country_code', $this->countryCode, array(
                    'expire' => time() + 86400
                ));
            } else {
                $this->countryCode = Yii::app()->request->cookies['country_code'];
            }
        }

        return $this->countryCode;
    }

    /**
     * OS detection needs for Bitlord download links
     */
    public function isMac()
    {
        if (stripos($this->getUserAgent(), 'mac')) {
            $this->isMac = true;
        }

        return $this->isMac;
    }
}