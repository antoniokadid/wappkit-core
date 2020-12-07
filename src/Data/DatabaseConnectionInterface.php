<?php

namespace AntonioKadid\WAPPKitCore\Data;

use AntonioKadid\WAPPKitCore\Data\Exceptions\DatabaseException;

/**
 * Interface DatabaseConnectionInterface.
 *
 * @package AntonioKadid\WAPPKitCore\Data
 */
interface DatabaseConnectionInterface
{
    /**
     * Commit the active transaction.
     *
     * @throws DatabaseException
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
     * @throws DatabaseException
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
     * @throws DatabaseException
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
