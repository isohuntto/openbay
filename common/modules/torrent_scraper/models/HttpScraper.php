<?php
namespace common\modules\torrent_scraper\models;

use Rych\Bencode\Bencode;
use Rych\Bencode\Exception\RuntimeException;

class HttpScraper extends BaseScraper
{

    protected $timeout = 30;

    /**
     * @param Tracker $tracker
     * @param array $hashes
     * @return null|array
     */
    public function scrape(Tracker $tracker, array $hashes)
    {
        $query = $this->prepareQueries($hashes);
        if (empty($query)) {
            return null;
        }

        return $this->collectData($tracker->getUrl(), $query);
    }

    /**
     * @param array $hashes
     * @return array
     */
    protected function prepareQueries(array $hashes)
    {
        $query = [];
        foreach ($hashes as $hash) {
            $query[] = 'info_hash=' . urlencode(hex2bin($hash));
        }
        return $query;
    }

    /**
     * @param string $url
     * @param array $query
     * @return array
     */
    protected function collectData($url, array $query)
    {
        $response = [];

        while (!empty($query)) {
            $length = strlen($url) + 1;
            $index = 1;
            foreach ($query as $param) {
                $length += strlen($param) + 1;
                if ($length <= 2000) {
                    $index++;
                } else {
                    break;
                }
            }
            $temp = array_splice($query, 0, $index);
            $response[] = $this->prepareData($this->request($url, $temp));
        }

        $result = ['files' => []];
        foreach ($response as $params) {
            if (!empty($params)) {
                $result = array_merge_recursive($result, $params);
            }
        }

        return $result['files'];
    }

    /**
     * @param $url
     * @param array $query
     * @return array|null
     */
    public function request($url, array $query)
    {
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url . '?' . join('&', $query),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => $this->timeout,
        ]);

        $result = curl_exec($ch);

        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($code != 200) {
            $result = null;
        }

        curl_close($ch);

        return $result;
    }

    /**
     * @param $data
     * @return array|null
     */
    protected function prepareData($data)
    {
        if (empty($data)) {
            return null;
        }
        try {
            $data = Bencode::decode($data);
        } catch (RuntimeException $e) {
            return null;
        }

        if (!(isset($data['files']) && is_array($data['files']))) {
            return null;
        }
        $prepared = ['files' => []];
        foreach ($data['files'] as $key => $value) {
            if (ctype_print($key)) {
                $prepared['files'][$key] = $value;
            } else {
                $prepared['files'][bin2hex($key)] = $value;
            }
        }
        return $prepared;
    }
}