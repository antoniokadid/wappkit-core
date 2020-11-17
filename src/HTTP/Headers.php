<?php

namespace AntonioKadid\WAPPKitCore\HTTP;

use AntonioKadid\WAPPKitCore\Collections\Map;

/**
 * Class Headers.
 *
 * @package AntonioKadid\WAPPKitCore\HTTP
 *
 * @url https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers
 */
class Headers extends Map
{
    /** @var string The size of the resource, in decimal number of bytes. */
    public const CONTENT_LENGTH = 'Content-Length';

    /** @var string Content-Type */
    public const CONTENT_TYPE = 'Content-Type';

    /**
     * @param string $headers
     *
     * @return Headers
     */
    public static function fromString(string $headers): Headers
    {
        $parts = preg_split('/\r\n|\r|\n/', $headers);

        $headers = new Headers();
        foreach ($parts as $part) {
            $result = preg_match('/^([^:]+):\s*(.*)$/', $part, $matches);
            if ($result === false || $result == 0) {
                continue;
            }

            $headers[$matches[1]] = $matches[2];
        }

        return $headers;
    }

    /**
     * @return array
     */
    public function asCURLHeaders(): array
    {
        if (empty($this->source)) {
            return $this->source;
        }

        $result = [];

        foreach ($this->source as $key => $value) {
            $result[] = sprintf('%s: %s', $key, $value);
        }

        return $result;
    }

    /**
     * @return bool
     */
    public function outputHeaders(): bool
    {
        if (headers_sent()) {
            return false;
        }

        foreach ($this->source as $key => $value) {
            header(sprintf('%s: %s', $key, $value));
        }

        return true;
    }
}
