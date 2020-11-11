<?php

namespace AntonioKadid\WAPPKitCore\Exceptions;

use AntonioKadid\WAPPKitCore\HTTP\Status;
use AntonioKadid\WAPPKitCore\Localization\ILanguage;
use Throwable;

/**
 * Class NotFoundException.
 *
 * @package AntonioKadid\WAPPKitCore\Exceptions
 */
class NotFoundException extends LocalizedException
{
    /**
     * NotFoundException constructor.
     *
     * @param string         $message
     * @param null|ILanguage $language
     * @param null|Throwable $previous
     */
    public function __construct(string $message = '', ILanguage $language = null, Throwable $previous = null)
    {
        parent::__construct($message, Status::NOT_FOUND, $language, $previous);
    }
}
