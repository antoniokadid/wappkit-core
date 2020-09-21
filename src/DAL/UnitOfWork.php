<?php

namespace AntonioKadid\WAPPKitCore\DAL;

use AntonioKadid\WAPPKitCore\Database\MySQL\Exceptions\MySQLException;
use AntonioKadid\WAPPKitCore\Database\MySQL\IMySQLConnection;

/**
 * Class UnitOfWork
 *
 * @package AntonioKadid\WAPPKitCore\DAL
 */
abstract class UnitOfWork
{
    /** @var IMySQLConnection */
    protected $_db = NULL;

    /**
     * Generate an ID.
     *
     * @param string $generatorName
     * @param int    $increment
     *
     * @return int
     * @throws MySQLException
     */
    public abstract function generateId(string $generatorName, int $increment = 1): int;

    /**
     * Reset an ID to a value.
     *
     * @param string $generatorName
     * @param int    $newValue
     *
     * @return bool
     * @throws MySQLException
     */
    public abstract function resetId(string $generatorName, int $newValue = 0): bool;

    /**
     * @return IMySQLConnection
     */
    public function getDb(): IMySQLConnection
    {
        return $this->_db;
    }
}