<?php

namespace AntonioKadid\WAPPKitCore\HTTP\Request;

use AntonioKadid\WAPPKitCore\Exceptions\JSONException;
use AntonioKadid\WAPPKitCore\JSON\JsonDecoder;

/**
 * Class JsonRequest
 *
 * @package AntonioKadid\WAPPKitCore\HTTP\Request
 */
class JsonRequest extends Request
{
    /**
     * JsonRequest constructor.
     *
     * @throws JSONException
     */
    public function __construct()
    {
        $decoder = new JsonDecoder(TRUE);
        $data = $decoder->decode(file_get_contents('php://input'));

        parent::__construct(($data === NULL || !is_array($data)) ? [] : $data);
    }
}