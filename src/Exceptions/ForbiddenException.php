<?php

namespace AntonioKadid\WAPPKitCore\Exceptions;

use AntonioKadid\WAPPKitCore\HTTP\Status;
use AntonioKadid\WAPPKitCore\Localization\ILanguage;
use Throwable;

/**
 * Class ForbiddenException.
 *
 * @package AntonioKadid\WAPPKitCore\Exceptions
 */
class ForbiddenException extends LocalizedException
{
    /**
     * ForbiddenException constructor.
     *
     * @param string         $message
     * @param null|ILanguage $language
     * @param null|Throwable $previous
     */
    public function __construct(string $message = '', ILanguage $language = null, Throwable $previous = null)
    {
        parent::__construct($message, Status::Forbidden, $language, $previous);
    }
}
