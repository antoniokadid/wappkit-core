<?php

namespace AntonioKadid\WAPPKitCore\Exceptions;

use AntonioKadid\WAPPKitCore\HTTP\Status;
use AntonioKadid\WAPPKitCore\Localization\ILanguage;
use Throwable;

/**
 * Class UnauthorizedException
 *
 * @package AntonioKadid\WAPPKitCore\Exceptions
 */
class UnauthorizedException extends LocalizedException
{
    /**
     * UnauthorizedException constructor.
     *
     * @param string         $message
     * @param ILanguage|null $language
     * @param Throwable|null $previous
     */
    public function __construct(string $message = '', ILanguage $language = NULL, Throwable $previous = NULL)
    {
        parent::__construct($message, Status::Unauthorized, $language, $previous);
    }
}