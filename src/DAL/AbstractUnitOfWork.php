<?php

namespace AntonioKadid\WAPPKitCore\DAL;

use AntonioKadid\WAPPKitCore\DAL\Exceptions\DatabaseException;

/**
 * Class AbstractUnitOfWork.
 *
 * @package AntonioKadid\WAPPKitCore\DAL
 */
abstract class AbstractUnitOfWork
{
    /** @var DatabaseConnectionInterface */
    protected $db = null;

    /**
     * Generate a UUID.
     *
     * @param string $prefix can be useful, for instance, if you generate identifiers simultaneously on several hosts
     *                       that might happen to generate the identifier at the same microsecond
     *
     * @return null|string
     */
    abstract public function generateUniqueId(string $prefix = ''): ?string;

    /**
     * Generate an ID.
     *
     * @param string $generatorName
     * @param int    $increment
     *
     * @throws DatabaseException
     *
     * @return null|int
     */
    abstract public function generateUniqueNumericId(string $generatorName, int $increment = 1): ?int;

    /**
     * @return DatabaseConnectionInterface
     */
    public function getDb(): DatabaseConnectionInterface
    {
        return $this->db;
    }
}
