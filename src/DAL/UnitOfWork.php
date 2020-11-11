<?php

namespace AntonioKadid\WAPPKitCore\DAL;

use AntonioKadid\WAPPKitCore\Database\MySQL\Exceptions\MySQLException;
use AntonioKadid\WAPPKitCore\Database\MySQL\IMySQLConnection;

/**
 * Class UnitOfWork.
 *
 * @package AntonioKadid\WAPPKitCore\DAL
 */
abstract class UnitOfWork
{
    /** @var IMySQLConnection */
    protected $db = null;

    /**
     * Generate an ID.
     *
     * @param string $generatorName
     * @param int    $increment
     *
     * @throws MySQLException
     *
     * @return int
     */
    abstract public function generateId(string $generatorName, int $increment = 1): int;

    /**
     * @return IMySQLConnection
     */
    public function getDb(): IMySQLConnection
    {
        return $this->db;
    }

    /**
     * Reset an ID to a value.
     *
     * @param string $generatorName
     * @param int    $newValue
     *
     * @throws MySQLException
     *
     * @return bool
     */
    abstract public function resetId(string $generatorName, int $newValue = 0): bool;
}
