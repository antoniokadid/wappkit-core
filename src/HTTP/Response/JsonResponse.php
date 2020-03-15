<?php

namespace AntonioKadid\WAPPKitCore\HTTP\Response;

use AntonioKadid\WAPPKitCore\Exceptions\JSONException;
use AntonioKadid\WAPPKitCore\JSON\JsonEncoder;
use ArrayAccess;

/**
 * Class JsonResponse
 *
 * @package AntonioKadid\WAPPKitCore\HTTP\Response
 */
class JsonResponse extends Response implements ArrayAccess
{
    /** @var array */
    private $_data = [];

    /**
     * JsonResponse constructor.
     *
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->_data = $data;
    }

    /**
     * @param array $data
     *
     * @throws JSONException
     */
    public static function respond(array $data = []): void
    {
        $response = new JsonResponse($data);
        $response->setHttpStatusCode(200);
        $response->output();
    }

    /**
     * @param array $_data
     *
     * @return JsonResponse
     */
    public function setData(array $_data): JsonResponse
    {
        $this->_data = $_data;

        return $this;
    }

    /**
     * @throws JSONException
     */
    public function output(): void
    {
        if (!headers_sent()) {
            header_remove('Content-Type');
            header('Content-Type: application/json');
        }

        if (ob_get_length() !== FALSE)
            ob_clean();

        http_response_code($this->httpStatus);

        $encoder = new JsonEncoder();

        echo $encoder->encode($this->_data);
    }

    /**
     * @inheritDoc
     */
    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->_data);
    }

    /**
     * @inheritDoc
     */
    public function offsetGet($offset)
    {
        if (!$this->offsetExists($offset))
            return NULL;

        return $this->_data[$offset];
    }

    /**
     * @inheritDoc
     */
    public function offsetSet($offset, $value)
    {
        $this->_data[$offset] = $value;
    }

    /**
     * @inheritDoc
     */
    public function offsetUnset($offset)
    {
        if (!$this->offsetExists($offset))
            return;

        unset($this->_data[$offset]);
    }
}