<?php

namespace AntonioKadid\WAPPKitCore\Models;

use AntonioKadid\WAPPKitCore\DAL\AbstractUnitOfWork;

/**
 * Class DatabaseModel.
 *
 * @package AntonioKadid\WAPPKitCore\Models
 */
abstract class DatabaseModel
{
    /** @var AbstractUnitOfWork */
    protected $unitOfWork;
}
