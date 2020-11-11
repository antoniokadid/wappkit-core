<?php

namespace AntonioKadid\WAPPKitCore\Models;

use AntonioKadid\WAPPKitCore\DAL\UnitOfWork;

/**
 * Class DatabaseModel.
 *
 * @package AntonioKadid\WAPPKitCore\Models
 */
abstract class DatabaseModel
{
    /** @var UnitOfWork */
    protected $unitOfWork;
}
