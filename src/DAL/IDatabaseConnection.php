<?php

namespace AntonioKadid\WAPPKitCore\DAL;

use AntonioKadid\WAPPKitCore\Exceptions\DatabaseException;

/**
 * Interface IDatabaseConnection.
 *
 * @package AntonioKadid\WAPPKitCore\DAL
 */
interface IDatabaseConnection
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
