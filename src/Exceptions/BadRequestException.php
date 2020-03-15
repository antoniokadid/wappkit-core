<?php

namespace AntonioKadid\WAPPKitCore\Exceptions;

use AntonioKadid\WAPPKitCore\HTTP\Status;
use Exception;

/**
 * Class BadRequestException
 *
 * @package AntonioKadid\WAPPKitCore\Exceptions
 */
class BadRequestException extends Exception
{
    /** @var string */
    private $_field;

    /**
     * BadRequestException constructor.
     *
     * @param string $message
     * @param string $field
     */
    public function __construct(string $message = '', string $field = '')
    {
        parent::__construct($message, Status::BadRequest);

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