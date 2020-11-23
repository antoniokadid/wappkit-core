<?php

namespace AntonioKadid\WAPPKitCore\HTTP\Exceptions;

use AntonioKadid\WAPPKitCore\Exceptions\WAPPKitCoreException;
use AntonioKadid\WAPPKitCore\HTTP\Status;
use Throwable;

/**
 * Class BadRequestException.
 *
 * @package AntonioKadid\WAPPKitCore\Exceptions
 */
class BadRequestException extends WAPPKitCoreException
{
    /** @var string */
    private $field;

    /**
     * BadRequestException constructor.
     *
     * @param string         $message
     * @param string         $field
     * @param null|Throwable $previous
     */
    public function __construct(
        string $message = '',
        string $field = '',
        Throwable $previous = null
    ) {
        parent::__construct($message, Status::BAD_REQUEST, $previous);

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
