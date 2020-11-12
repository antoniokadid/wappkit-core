<?php

namespace AntonioKadid\WAPPKitCore\Database\MySQL;

use AntonioKadid\WAPPKitCore\Database\Exceptions\MySQLException;

/**
 * Interface IMySQLConnection.
 *
 * @package AntonioKadid\WAPPKitCore\Database\MySQL
 */
interface IMySQLConnection
{
    /**
     * Commit the active transaction.
     *
     * @throws MySQLException
     *
     * @return bool
     */
    public function commit(): bool;

    /**
     * Execute a DELETE, INSERT or UPDATE query.
     *
     * @param string $sql
     * @param array  $params
     *
     * @throws MySQLException
     *
     * @return int the number of affected rows
     */
    public function execute(string $sql, array $params = []): int;

    /**
     * Execute a SELECT query.
     *
     * @param string $sql
     * @param array  $params
     *
     * @throws MySQLException
     *
     * @return array
     */
    public function query(string $sql, array $params = []): array;


    /**
     * Rollback the active transaction.
     *
     * @return bool
     */
    public function rollback(): bool;
}
