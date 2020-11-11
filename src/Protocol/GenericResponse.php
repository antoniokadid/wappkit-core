<?php

namespace AntonioKadid\WAPPKitCore\Protocol;

use AntonioKadid\WAPPKitCore\HTTP\Headers;
use AntonioKadid\WAPPKitCore\HTTP\Response\Response;
use AntonioKadid\WAPPKitCore\Localization\ILanguage;

/**
 * Class GenericResponse.
 *
 * @package AntonioKadid\WAPPKitCore\Protocol
 */
abstract class GenericResponse extends Response
{
    /** @var ILanguage */
    public $language;

    final public function output(): void
    {
        if (ob_get_length() !== false) {
            ob_clean();
        }

        http_response_code($this->httpStatus);

        $headers = $this->responseHeaders();
        if ($headers != null) {
            $headers->outputHeaders();
        }

        echo $this->responseBody();
    }

    /**
     * @return mixed
     */
    abstract protected function responseBody();

    /**
     * @return null|Headers
     */
    abstract protected function responseHeaders(): ?Headers;
}
