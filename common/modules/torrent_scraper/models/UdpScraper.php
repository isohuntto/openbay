<?php
namespace common\modules\torrent_scraper\models;

use common\models\ScraperException;

class UdpScraper extends BaseScraper
{
    const ACTION_CONNECT = 0;
    const ACTION_ANNOUNCE = 1;
    const ACTION_SCRAPE = 2;
    const ACTION_ERROR = 3;

    const CONNECTION_ID = "\x00\x00\x04\x17\x27\x10\x19\x80";

    protected $currentConnectionId = null;
    protected $transactionId = null;

    protected $socket = null;

    protected $timeout = 15;

    public function scrape(Tracker $tracker, array $hashes)
    {
        $chunks = array_chunk($hashes, 74);

        $result = [];
        foreach ($chunks as $chunk) {
            $result = array_merge($result, $this->scrapeChunk($tracker, $chunk));
        }
        return $result;
    }

    public function scrapeChunk(Tracker $tracker, $hashes)
    {
        $this->initSocket();

        $this->connect($tracker->host, $tracker->port);

        $this->startTransaction();

        $torrents = $this->scrapeHashes($hashes);

        $this->closeSocket();

        return $torrents;
    }

    protected function initSocket()
    {
        if ($this->socket === null) {
            $socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
            if ($socket === false) {
                throw new UdpScraperException(socket_strerror(socket_last_error()));
            }
            $this->socket = $socket;
        }
        return $this->socket;
    }

    protected function connect($domain, $port)
    {
        if (socket_connect($this->socket, $domain, $port) === false) {
            throw new UdpScraperException(socket_strerror(socket_last_error($this->socket)));
        }
    }

    protected function generateTransactionId()
    {
        $this->transactionId = mt_rand(0, 65535);
    }

    protected function startTransaction()
    {
        $this->generateTransactionId();
        $packet = static::CONNECTION_ID . pack('N', static::ACTION_CONNECT) . pack('N', $this->transactionId);
        $res = $this->request($packet, 16);
        if (strlen($res) < 1) {
            throw new UdpScraperException('No connection response.');
        }
        if (strlen($res) < 16) {
            throw new UdpScraperException('Too short connection response.');
        }
        $resUnpacked = unpack("Naction/Ntransid", $res);

        if ($resUnpacked['action'] != static::ACTION_CONNECT || $resUnpacked['transid'] != $this->transactionId) {
            throw new UdpScraperException('Invalid connection response.');
        }

        $this->currentConnectionId = substr($res, 8, 8);
    }

    protected function scrapeHashes($hashes)
    {
        $hashString = '';
        foreach ($hashes as $hash) {
            $hashString .= pack('H*', $hash);
        }

        $packet = $this->currentConnectionId . pack("N", static::ACTION_SCRAPE) . pack("N", $this->transactionId) . $hashString;

        $readLength = 8 + (12 * count($hashes));

        $res = $this->request($packet, $readLength);

        if (strlen($res) < 1) {
            throw new UdpScraperException('No scrape response.');
        }
        if (strlen($res) < 8) {
            throw new UdpScraperException('Too short scrape response.');
        }

        $resUnpacked = unpack("Naction/Ntransid", $res);

        if ($resUnpacked['action'] == static::ACTION_ERROR) {
            $this->checkError($res);
        }

        if (strlen($res) < $readLength) {
            throw new UdpScraperException('Too short scrape response.');
        }

        $torrents = [];
        $index = 8;
        foreach ($hashes as $hash) {
            $resUnpacked = unpack("Ncomplete/Ndownloaded/Nincomplete", substr($res, $index, 12));
            $torrents[$hash] = $resUnpacked;
            $index = $index + 12;
        }
        return $torrents;
    }

    protected function request($packet, $readLength)
    {
        socket_set_option($this->socket, SOL_SOCKET, SO_RCVTIMEO, ['sec' => $this->timeout, 'usec' => 0]);
        socket_set_option($this->socket, SOL_SOCKET, SO_SNDTIMEO, ['sec' => $this->timeout, 'usec' => 0]);

        if (socket_write($this->socket, $packet, strlen($packet)) === false) {
            throw new UdpScraperException(socket_strerror(socket_last_error($this->socket)));
        }

        $res = socket_read($this->socket, $readLength, PHP_BINARY_READ);
        return $res;
    }

    protected function closeSocket()
    {
        if ($this->socket) {
            socket_close($this->socket);
            $this->socket = null;
            $this->transactionId = null;
            $this->currentConnectionId = null;
        }
    }

    protected function checkError($response)
    {
        $unpacked = unpack("Naction/Ntransid/H*error", $response);
        throw new UdpScraperException($unpacked['error']);
    }
}