<?php

namespace AntonioKadid\WAPPKitCore\Models;

use AntonioKadid\WAPPKitCore\DAL\UnitOfWork;

/**
 * Interface IDatabaseModel.
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
    public static function all(UnitOfWork $unitOfWork): array;

    /**
     * @return bool
     */
    public function add(): bool;

    /**
     * @return bool
     */
    public function delete(): bool;

    /**
     * @return bool
     */
    public function update(): bool;
}
