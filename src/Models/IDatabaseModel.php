<?php

namespace AntonioKadid\WAPPKitCore\Models;

use AntonioKadid\WAPPKitCore\DAL\AbstractUnitOfWork;

/**
 * Interface IDatabaseModel.
 *
 * @package AntonioKadid\WAPPKitCore\Models
 */
interface IDatabaseModel
{
    /**
     * @param AbstractUnitOfWork $unitOfWork
     *
     * @return array
     */
    public static function all(AbstractUnitOfWork $unitOfWork): array;

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
