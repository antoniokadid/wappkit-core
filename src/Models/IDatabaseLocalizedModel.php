<?php

namespace AntonioKadid\WAPPKitCore\Models;

use AntonioKadid\WAPPKitCore\DAL\UnitOfWork;
use AntonioKadid\WAPPKitCore\Localization\ILanguage;

/**
 * Interface IDatabaseLocalizedModel.
 *
 * @package AntonioKadid\WAPPKitCore\Models
 */
interface IDatabaseLocalizedModel
{
    /**
     * @param UnitOfWork $unitOfWork
     * @param ILanguage  $language
     *
     * @return array
     */
    public static function all(UnitOfWork $unitOfWork, ILanguage $language): array;

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
