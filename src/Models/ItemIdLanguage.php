<?php

namespace AntonioKadid\WAPPKitCore\Models;

use AntonioKadid\WAPPKitCore\Localization\ILanguage;

/**
 * Class ItemIdLanguage
 *
 * @package AntonioKadid\WAPPKitCore\Models
 */
abstract class ItemIdLanguage
    extends DatabaseModel
    implements IDatabaseLocalizedModel
{
    /** @var int|NULL */
    public $id = NULL;

    /** @var ILanguage|NULL */
    public $language = NULL;
}