<?php

namespace AntonioKadid\WAPPKitCore\Exceptions;

use AntonioKadid\WAPPKitCore\HTTP\Status;
use AntonioKadid\WAPPKitCore\Localization\ILanguage;
use Throwable;

/**
 * Class BadRequestException
 *
 * @package AntonioKadid\WAPPKitCore\Exceptions
 */
class BadRequestException extends LocalizedException
{
    /** @var string */
    private $_field;

    /**
     * BadRequestException constructor.
     *
     * @param string         $message
     * @param string         $field
     * @param ILanguage|null $language
     * @param Throwable|null $previous
     */
    public function __construct(string $message = '', string $field = '', ILanguage $language = NULL, Throwable $previous = NULL)
    {
        parent::__construct($message, Status::BadRequest, $language, $previous);

        $this->_field = $field;
    }

    /**
     * @return string
     */
    public function getField(): string
    {
        return $this->_field;
    }
}