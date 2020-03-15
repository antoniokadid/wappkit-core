<?php

namespace AntonioKadid\WAPPKitCore\Exceptions;

use AntonioKadid\WAPPKitCore\HTTP\Status;
use Exception;

/**
 * Class NotFoundException
 *
 * @package AntonioKadid\WAPPKitCore\Exceptions
 */
class NotFoundException extends Exception
{
    /**
     * NotFoundException constructor.
     *
     * @param string $message
     */
    public function __construct(string $message = '')
    {
        parent::__construct($message, Status::NotFound);
    }
}