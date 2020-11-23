<?php

namespace AntonioKadid\WAPPKitCore\HTTP\Exceptions;

use AntonioKadid\WAPPKitCore\Exceptions\WAPPKitCoreException;
use AntonioKadid\WAPPKitCore\HTTP\Status;
use AntonioKadid\WAPPKitCore\Localization\ILanguage;
use Throwable;

/**
 * Class UnauthorizedException.
 *
 * @package AntonioKadid\WAPPKitCore\Exceptions
 */
class UnauthorizedException extends WAPPKitCoreException
{
    /**
     * UnauthorizedException constructor.
     *
     * @param string         $message
     * @param null|ILanguage $language
     * @param null|Throwable $previous
     */
    public function __construct(string $message = '', ILanguage $language = null, Throwable $previous = null)
    {
        parent::__construct($message, Status::UNAUTHORIZED, $language, $previous);
    }
}
