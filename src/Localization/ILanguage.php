<?php

namespace AntonioKadid\WAPPKitCore\Localization;

/**
 * Interface ILanguage
 *
 * @package AntonioKadid\WAPPKitCore\Localization
 */
interface ILanguage
{
    /**
     * @return int
     */
    function getId(): int;

    /**
     * @return string
     */
    function getName(): string;

    /**
     * @return string
     */
    function getCode(): string;
}