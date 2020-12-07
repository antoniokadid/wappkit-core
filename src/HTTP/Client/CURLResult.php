<?php

namespace AntonioKadid\WAPPKitCore\HTTP\Client;

/**
 * Class CURLResult.
 *
 * @package AntonioKadid\WAPPKitCore\HTTP\Client
 */
class CURLResult
{
    /** @var string */
    private $body;
    /** @var array */
    private $headers;
    /** @var int */
    private $responseCode;

    /**
     * CURLResult constructor.
     *
     * @param int    $responseCode
     * @param array  $headers
     * @param string $body
     */
    public function __construct(int $responseCode, array $headers, string $body)
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
     * @return array
     */
    public function getHeaders(): array
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
