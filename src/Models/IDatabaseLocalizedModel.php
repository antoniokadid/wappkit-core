<?php

namespace AntonioKadid\WAPPKitCore\Models;

use AntonioKadid\WAPPKitCore\DAL\AbstractUnitOfWork;
use AntonioKadid\WAPPKitCore\Localization\ILanguage;

/**
 * Interface IDatabaseLocalizedModel.
 *
 * @package AntonioKadid\WAPPKitCore\Models
 */
interface IDatabaseLocalizedModel
{
    /**
     * @param AbstractUnitOfWork $unitOfWork
     * @param ILanguage  $language
     *
     * @return array
     */
    public static function all(AbstractUnitOfWork $unitOfWork, ILanguage $language): array;

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
