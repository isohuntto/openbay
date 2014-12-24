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
     * Tries to determine the user's IP address
     *
     * Note that this method does not return the actual IP address of the user
     * when the user connects from behind for example a proxy (the IP address
     * of the proxy will be returned in that case)
     *
     * @return string user IP address
     */
    public function getUserHostAddress()
    {
        if (isset($_SERVER['REMOTE_ADDR']) && $this->validateIp($_SERVER['REMOTE_ADDR'])) {
            return $this->ipAddress = $_SERVER['REMOTE_ADDR'];
        }

        // NOTE: or use something like this 127.0.0.2
        return ($this->ipAddress = '0.0.0.0');
    }

    /**
     * Tries to determine the user's "real" IP address
     *
     * This method tries to find the user's IP address even when the user makes
     * requests from behind a proxy. This method should *not* be used for validating
     * whether a user is allowed access because the only thing that can be trusted
     * is $_SERVER['REMOTE_ADDR']
     *
     * @return string user IP address
     */
    public function getUnsafeUserHostAddress()
    {
        if (!is_null($this->ipAddress)) {
            return $this->ipAddress;
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
                    if ($this->validateIp(trim($ip))) {
                        return ($this->ipAddress = $ip);
                    }
                }
            }
        }

        // NOTE: or use something like this 127.0.0.2
        return ($this->ipAddress = '0.0.0.0');
    }

    /**
     * Validates an IP address
     *
     * Allows only IPv4 address, Denies reserved addresses and private addresses
     *
     * @param string $ipAddress The IP address to validate
     *
     * @return bool True when the Ip address is valid
     */
    private function validateIp($ipAddress)
    {
        return filter_var($ipAddress, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false;
    }

    public function getCountryCode()
    {
        if (empty($this->countryCode) && ! YII_DEBUG) {
            if (empty(Yii::app()->request->cookies['country_code'])) {
                $this->countryCode = geoip_country_code_by_name($this->getUnsafeUserHostAddress());
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