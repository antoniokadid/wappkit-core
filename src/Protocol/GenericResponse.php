<?php

namespace AntonioKadid\WAPPKitCore\Protocol;

use AntonioKadid\WAPPKitCore\HTTP\Headers;
use AntonioKadid\WAPPKitCore\HTTP\Response\Response;
use AntonioKadid\WAPPKitCore\Localization\ILanguage;

/**
 * Class GenericResponse
 *
 * @package AntonioKadid\WAPPKitCore\Protocol
 */
abstract class GenericResponse extends Response
{
    /** @var ILanguage */
    public $language;

    public final function output(): void
    {
        if (ob_get_length() !== FALSE)
            ob_clean();

        http_response_code($this->httpStatus);

        $headers = $this->responseHeaders();
        if ($headers != NULL)
            $headers->outputHeaders();

        echo $this->responseBody();
    }

    /**
     * @return Headers|null
     */
    protected abstract function responseHeaders(): ?Headers;

    /**
     * @return mixed
     */
    protected abstract function responseBody();
}