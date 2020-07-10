<?php

namespace AntonioKadid\WAPPKitCore\DAL;

use AntonioKadid\WAPPKitCore\Database\MySQL\Exceptions\MySQLException;
use AntonioKadid\WAPPKitCore\Database\MySQL\IMySQLConnection;

/**
 * Class
 *
 * @package Database
 */
abstract class UnitOfWork
{
    /** @var IMySQLConnection */
    private $_db = NULL;

    /**
     * @param string $generatorName
     * @param int    $increment
     *
     * @return int
     * @throws MySQLException
     */
    public abstract function genId(string $generatorName, int $increment = 1): int;

    /**
     * @param string $generatorName
     * @param int    $newValue
     *
     * @return bool
     * @throws MySQLException
     */
    public abstract function resetGenId(string $generatorName, int $newValue = 0): bool;

    /**
     * @return IMySQLConnection
     */
    public function getDb(): IMySQLConnection
    {
        return $this->_db;
    }
}