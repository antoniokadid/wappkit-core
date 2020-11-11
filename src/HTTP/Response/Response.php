<?php

namespace AntonioKadid\WAPPKitCore\HTTP\Response;

use AntonioKadid\WAPPKitCore\HTTP\Status;

/**
 * Class Response.
 *
 * @package AntonioKadid\WAPPKitCore\HTTP\Response
 */
abstract class Response implements IResponse
{
    /** @var int */
    protected $httpStatus = Status::OK;

    abstract public function output();

    /**
     * @param int $httpStatusCode
     *
     * @return static
     */
    public function setHttpStatusCode(int $httpStatusCode)
    {
        $this->httpStatus = $httpStatusCode;

        return $this;
    }
}
