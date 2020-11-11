<?php

namespace AntonioKadid\WAPPKitCore\HTTP\Client;

use AntonioKadid\WAPPKitCore\HTTP\Headers;

/**
 * Class CURLResult.
 *
 * @package AntonioKadid\WAPPKitCore\HTTP\Client
 */
class CURLResult
{
    /** @var string */
    private $body;
    /** @var Headers */
    private $headers;
    /** @var int */
    private $responseCode;

    /**
     * CURLResult constructor.
     *
     * @param int     $responseCode
     * @param Headers $headers
     * @param string  $body
     */
    public function __construct(int $responseCode, Headers $headers, string $body)
    {
        $this->responseCode = $responseCode;
        $this->headers      = $headers;
        $this->body         = $body;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @return Headers
     */
    public function getHeaders(): Headers
    {
        return $this->headers;
    }

    /**
     * @return int
     */
    public function getResponseCode(): int
    {
        return $this->responseCode;
    }
}
