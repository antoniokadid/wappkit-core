<?php

namespace AntonioKadid\WAPPKitCore\DAL;

use AntonioKadid\WAPPKitCore\Exceptions\DatabaseException;

/**
 * Class UnitOfWork.
 *
 * @package AntonioKadid\WAPPKitCore\DAL
 */
abstract class UnitOfWork
{
    /** @var IDatabaseConnection */
    protected $db = null;

    /**
     * Generate an ID.
     *
     * @param string $generatorName
     * @param int    $increment
     *
     * @throws DatabaseException
     *
     * @return int
     */
    abstract public function generateId(string $generatorName, int $increment = 1): int;

    /**
     * @return IDatabaseConnection
     */
    public function getDb(): IDatabaseConnection
    {
        return $this->db;
    }

    /**
     * Reset an ID to a value.
     *
     * @param string $generatorName
     * @param int    $newValue
     *
     * @throws DatabaseException
     *
     * @return bool
     */
    abstract public function resetId(string $generatorName, int $newValue = 0): bool;
}
