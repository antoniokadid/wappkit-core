<?php

namespace AntonioKadid\WAPPKitCore\HTTP\Request;

use DateTime;
use DateTimeZone;

/**
 * Class Request.
 *
 * @package AntonioKadid\WAPPKitCore\HTTP\Request
 */
class Request
{
    /**
     * @return Request
     *
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    public static function get(): array
    {
        return $_GET;
    }

    /**
     * @return string
     *
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    public static function getMethod(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * @return string
     *
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    public static function getQueryString(): string
    {
        return $_SERVER['QUERY_STRING'];
    }

    /**
     * @return null|string
     *
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    public static function getRemoteIp(): ?string
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
    public static function getUri(): string
    {
        return $_SERVER['REQUEST_URI'];
    }

    /**
     * @return string
     *
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    public static function getUserAgent(): string
    {
        return $_SERVER['HTTP_USER_AGENT'];
    }

    /**
     * @return Request
     */
    public static function json(): array
    {
        $data = json_decode(
            file_get_contents('php://input'),
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        return ($data === null || !is_array($data)) ? [] : $data;
    }

    /**
     * @return Request
     *
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    public static function post(): array
    {
        return $_POST;
    }

    /**
     * @param string $timezone
     *
     * @return DateTime
     *
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    public static function time(string $timezone = 'UTC'): DateTime
    {
        return new DateTime("@$_SERVER[REQUEST_TIME]", new DateTimeZone($timezone));
    }
}
