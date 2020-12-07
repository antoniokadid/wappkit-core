<?php

namespace AntonioKadid\WAPPKitCore\HTTP;

/**
 * Class Headers.
 *
 * @package AntonioKadid\WAPPKitCore\HTTP
 *
 * @url https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers
 */
class Headers
{
    /** @var string The size of the resource, in decimal number of bytes. */
    public const CONTENT_LENGTH = 'Content-Length';

    /** @var string Content-Type */
    public const CONTENT_TYPE = 'Content-Type';

    /**
     * @return array
     */
    public static function asCURLHeaders(array $headers): array
    {
        if (empty($headers)) {
            return $headers;
        }

        $result = [];

        foreach ($headers as $key => $value) {
            $result[] = sprintf('%s: %s', $key, $value);
        }

        return $result;
    }

    /**
     * @param string $headers
     *
     * @return array
     */
    public static function fromString(string $headers): array
    {
        $parts = preg_split('/\r\n|\r|\n/', $headers, -1, PREG_SPLIT_NO_EMPTY);

        $headers = [];
        foreach ($parts as $part) {
            $matches = [];

            $result = preg_match('/^([^:]+):\s*(.*)$/', $part, $matches);
            if ($result === false || $result == 0) {
                continue;
            }

            $headers[$matches[1]] = $matches[2];
        }

        return $headers;
    }

    /**
     * @return bool
     */
    public static function outputHeaders(array $headers): bool
    {
        if (headers_sent()) {
            return false;
        }

        foreach ($headers as $key => $value) {
            header(sprintf('%s: %s', $key, $value));
        }

        return true;
    }
}
