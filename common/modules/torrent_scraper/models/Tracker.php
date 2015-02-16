<?php

namespace common\modules\torrent_scraper\models;

class Tracker
{
    public $scheme;
    public $host;
    public $port;
    public $path;
    public $query;

    protected $allowedSchemes = [
        'http',
        'https',
        'udp'
    ];

    /**
     * @param string $name
     * @throws TrackerException
     */
    public function __construct($name)
    {
        $name = trim($name);
        if (!preg_match('#^[a-z]+://#', $name)) {
            $name = 'http://' . $name;
        }
        if (!filter_var($name, FILTER_VALIDATE_URL)) {
            throw new TrackerException('Not valid url');
        }

        $params = parse_url($name);
        $this->scheme = !empty($params['scheme']) ? $params['scheme'] : 'http';
        $this->host = !empty($params['host']) ? $params['host'] : null;
        $this->port = !empty($params['port']) ? (int)$params['port'] : 80;
        $this->path = !empty($params['path']) ? $params['path'] : '/';
        $this->query = !empty($params['query']) ? $params['query'] : '';

        if (!in_array($this->scheme, $this->allowedSchemes)) {
            throw new TrackerException('Empty host');
        }

        if (empty($this->host)) {
            throw new TrackerException('Empty host');
        }
    }

    /**
     * @param string $name
     * @return null|Tracker
     */
    public static function parse($name)
    {
        try {
            $class = get_called_class();
            return new $class($name);
        } catch (TrackerException $e) {
            return null;
        }
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->scheme . '://'
        . $this->host
        . ($this->port === 80 ? '' : ':' . $this->port)
        . $this->path
        . (empty($this->query) ? '' : '?' . $this->query);
    }
}