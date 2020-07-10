<?php

namespace AntonioKadid\WAPPKitCore\Models;

use AntonioKadid\WAPPKitCore\DAL\UnitOfWork;
use AntonioKadid\WAPPKitCore\Localization\ILanguage;

/**
 * Interface IDatabaseLocalizedModel
 *
 * @package AntonioKadid\WAPPKitCore\Models
 */
interface IDatabaseLocalizedModel
{
    /**
     * @param UnitOfWork $unitOfWork
     * @param ILanguage $language
     *
     * @return array
     */
    static function all(UnitOfWork $unitOfWork, ILanguage $language): array;

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