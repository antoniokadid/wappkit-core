<?php

namespace AntonioKadid\WAPPKitCore\HTTP\Response;

use AntonioKadid\WAPPKitCore\HTTP\Headers;
use AntonioKadid\WAPPKitCore\HTTP\Status;

/**
 * Class Response.
 *
 * @package AntonioKadid\WAPPKitCore\HTTP\Response
 */
abstract class Response implements ResponseInterface
{
    /** @var int */
    protected $httpStatus = Status::OK;

    final public function output(): void
    {
        if (ob_get_length() !== false) {
            ob_clean();
        }

        http_response_code($this->httpStatus);

        $headers = $this->headers();
        if ($headers != null) {
            $headers->outputHeaders();
        }

        $body = $this->body();
        if ($body != null) {
            echo $body;
        }
    }

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

    /**
     * @return mixed
     */
    abstract protected function body();

    /**
     * @return null|Headers
     */
    abstract protected function headers(): ?Headers;
}
