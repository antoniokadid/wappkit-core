<?php

namespace AntonioKadid\WAPPKitCore\HTTP\Request;

/**
 * Class JSONRequest.
 *
 * @package AntonioKadid\WAPPKitCore\HTTP\Request
 */
class JSONRequest extends Request
{
    /**
     * JSONRequest constructor.
     */
    public function __construct()
    {
        $data = json_decode(file_get_contents('php://input'), true, 512, JSON_THROW_ON_ERROR);

        parent::__construct(($data === null || !is_array($data)) ? [] : $data);
    }
}
