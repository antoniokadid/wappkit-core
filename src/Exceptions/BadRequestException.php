<?php

namespace AntonioKadid\WAPPKitCore\Exceptions;

use AntonioKadid\WAPPKitCore\HTTP\Status;
use AntonioKadid\WAPPKitCore\Localization\ILanguage;
use Throwable;

/**
 * Class BadRequestException.
 *
 * @package AntonioKadid\WAPPKitCore\Exceptions
 */
class BadRequestException extends LocalizedException
{
    /** @var string */
    private $field;

    /**
     * BadRequestException constructor.
     *
     * @param string         $message
     * @param string         $field
     * @param null|ILanguage $language
     * @param null|Throwable $previous
     */
    public function __construct(
        string $message = '',
        string $field = '',
        ILanguage $language = null,
        Throwable $previous = null
    ) {
        parent::__construct($message, Status::BadRequest, $language, $previous);

        $this->field = $field;
    }

    /**
     * @return string
     */
    public function getField(): string
    {
        return $this->field;
    }
}
