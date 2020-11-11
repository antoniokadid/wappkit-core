<?php

namespace AntonioKadid\WAPPKitCore\Localization;

/**
 * Interface ILanguage.
 *
 * @package AntonioKadid\WAPPKitCore\Localization
 */
interface ILanguage
{
    /**
     * @return string
     */
    public function getCode(): string;

    /**
     * @return int
     */
    public function getId(): int;

    /**
     * @return string
     */
    public function getName(): string;
}
