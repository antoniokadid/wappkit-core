<?php

namespace AntonioKadid\WAPPKitCore\HTTP\Client;

use AntonioKadid\WAPPKitCore\HTTP\Headers;

/**
 * Class CURLOptions.
 *
 * @package AntonioKadid\WAPPKitCore\HTTP\Client
 */
class CURLOptions
{
    /**
     * CURLOptions constructor.
     */
    public function __construct()
    {
    }

    /** @var int */
    public $connectTimeout = 0;
    /** @var int */
    public $executionTimeout = 0;
    /** @var array */
    public $headers = [];
    /** @var bool */
    public $verifyCertificateStatus = false;
    /** @var bool */
    public $verifyHost = false;
    /** @var bool */
    public $verifyPeer = false;

    /**
     * @param resource $curl CURL Resource
     */
    public function setup($curl): void
    {
        if ($this->headers != null) {
            curl_setopt($curl, CURLOPT_HTTPHEADER, Headers::asCURLHeaders($this->headers));
        }

        // SSL
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, $this->verifyHost === true ? 2 : 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, $this->verifyPeer === true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYSTATUS, $this->verifyCertificateStatus === true);

        // TIMEOUTS
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $this->connectTimeout);
        curl_setopt($curl, CURLOPT_TIMEOUT, $this->executionTimeout);
    }
}
