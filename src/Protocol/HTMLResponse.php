<?php

namespace AntonioKadid\WAPPKitCore\Protocol;

use AntonioKadid\WAPPKitCore\HTTP\Headers;

/**
 * Class HTMLResponse
 *
 * @package AntonioKadid\WAPPKitCore\Protocol
 */
abstract class HTMLResponse extends GenericResponse
{
    /**
     * @inheritDoc
     */
    protected function responseHeaders(): ?Headers
    {
        return new Headers([
            'Content-Type' => 'text/html'
        ]);
    }
}