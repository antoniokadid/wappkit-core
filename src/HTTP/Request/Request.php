<?php

namespace AntonioKadid\WAPPKitCore\HTTP\Request;

use AntonioKadid\WAPPKitCore\Collections\Map;

/**
 * Class Request.
 *
 * @package AntonioKadid\WAPPKitCore\HTTP\Request
 */
class Request extends Map
{
    /**
     * Request constructor.
     *
     * @param array $source An array to initialize request. Array keys are preserved. [optional]
     */
    private function __construct(array $source = [])
    {
        parent::__construct($source);
    }

    /**
     * @return Request
     *
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    public static function get(): Request
    {
        return new Request($_GET);
    }

    /**
     * @return Request
     */
    public static function json(): Request
    {
        $data = json_decode(
            file_get_contents('php://input'),
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        return new Request(($data === null || !is_array($data)) ? [] : $data);
    }

    /**
     * @return Request
     *
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    public static function post(): Request
    {
        return new Request($_POST);
    }

    /**
     * @return string
     *
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    public function getMethod(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * @return string
     *
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    public function getQueryString(): string
    {
        return $_SERVER['QUERY_STRING'];
    }

    /**
     * @return null|string
     *
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    public function getRemoteIp(): ?string
    {
        if (isset($_SERVER['HTTP_CLIENT_IP']) && !empty($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        }

        if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && !empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        }

        if (isset($_SERVER['REMOTE_ADDR']) && !empty($_SERVER['REMOTE_ADDR'] != '')) {
            return $_SERVER['REMOTE_ADDR'];
        }

        return null;
    }

    /**
     * @return string
     *
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    public function getUri(): string
    {
        return $_SERVER['REQUEST_URI'];
    }

    /**
     * @return string
     *
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    public function getUserAgent(): string
    {
        return $_SERVER['HTTP_USER_AGENT'];
    }
}
