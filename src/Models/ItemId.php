<?php

namespace AntonioKadid\WAPPKitCore\Models;

/**
 * Class ItemId
 *
 * @package AntonioKadid\WAPPKitCore\Models
 */
abstract class ItemId
    extends DatabaseModel
    implements IDatabaseModel
{
    /** @var int $id */
    public $id = NULL;
}