<?php

namespace AntonioKadid\WAPPKitCore\Models;

use AntonioKadid\WAPPKitCore\DAL\UnitOfWork;

/**
 * Interface IDatabaseModel
 *
 * @package AntonioKadid\WAPPKitCore\Models
 */
interface IDatabaseModel
{
    /**
     * @param UnitOfWork $unitOfWork
     *
     * @return array
     */
    static function all(UnitOfWork $unitOfWork): array;

    /**
     * @return bool
     */
    function add(): bool;

    /**
     * @return bool
     */
    function delete(): bool;

    /**
     * @return bool
     */
    function update(): bool;
}