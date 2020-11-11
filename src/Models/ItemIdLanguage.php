<?php

namespace AntonioKadid\WAPPKitCore\Models;

use AntonioKadid\WAPPKitCore\Localization\ILanguage;

/**
 * Class ItemIdLanguage.
 *
 * @package AntonioKadid\WAPPKitCore\Models
 */
abstract class ItemIdLanguage extends DatabaseModel implements IDatabaseLocalizedModel
{
    /** @var null|int */
    public $id = null;

    /** @var null|ILanguage */
    public $language = null;
}
