<?php

namespace AntonioKadid\WAPPKitCore\HTTP\Response;

use AntonioKadid\WAPPKitCore\HTTP\Headers;

/**
 * Class HTMLResponse.
 *
 * @package AntonioKadid\WAPPKitCore\HTTP\Response
 */
abstract class HTMLResponse extends Response
{
    /**
     * {@inheritdoc}
     */
    protected function headers(): ?Headers
    {
        return new Headers([
            'Content-Type' => 'text/html'
        ]);
    }
}
