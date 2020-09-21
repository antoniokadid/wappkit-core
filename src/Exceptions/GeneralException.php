<?php

namespace AntonioKadid\WAPPKitCore\Exceptions;

use AntonioKadid\WAPPKitCore\Localization\ILanguage;
use Throwable;

/**
 * Class GeneralException
 *
 * @package AntonioKadid\WAPPKitCore\Exceptions
 */
class GeneralException extends LocalizedException
{
    public function __construct($message = '', $code = 0, ILanguage $language = NULL, Throwable $previous = NULL)
    {
        parent::__construct($message, $code, $language, $previous);
    }
}