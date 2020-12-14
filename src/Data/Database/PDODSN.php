<?php

namespace AntonioKadid\WAPPKitCore\Data\Database;

/**
 * Class PDODSN (PDO Data Source Name).
 *s.
 *
 * @package AntonioKadid\WAPPKitCore\Data\Database
 */
class PDODSN
{
    /**
     * @param string $host
     * @param int    $port
     * @param string $dbName
     * @param string $encoding
     *
     * @return string
     */
    public static function mysql(string $host, int $port, string $dbName, string $encoding = 'utf8'): string
    {
        return sprintf('mysql:host=%s;port=%d;dbname=%s;charset=%s', $host, $port, $dbName, $encoding);
    }
}
