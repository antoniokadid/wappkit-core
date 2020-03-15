<?php

namespace AntonioKadid\WAPPKitCore\Database;

use AntonioKadid\WAPPKitCore\Exceptions\DatabaseException;

/**
 * Interface IDatabaseConnection
 *
 * @package AntonioKadid\WAPPKitCore\Database
 */
interface IDatabaseConnection
{
    /**
     * Commit the active transaction.
     *
     * @return bool
     *
     * @throws DatabaseException
     */
    function commit(): bool;

    /**
     * Execute a DELETE, INSERT or UPDATE query.
     *
     * @param string $sql
     * @param array  $params
     *
     * @return int The number of affected rows.
     *
     * @throws DatabaseException
     */
    function execute(string $sql, array $params = []): int;

    /**
     * Execute a SELECT query.
     *
     * @param string $sql
     * @param array  $params
     *
     * @return array
     *
     * @throws DatabaseException
     */
    function query(string $sql, array $params = []): array;


    /**
     * Rollback the active transaction.
     *
     * @return bool
     */
    function rollback(): bool;
}