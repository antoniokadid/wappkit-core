<?php

namespace AntonioKadid\WAPPKitCore\Protocol;

use AntonioKadid\WAPPKitCore\HTTP\Headers;
use ArrayAccess;

/**
 * Class JSONResponse.
 *
 * @package AntonioKadid\WAPPKitCore\Protocol
 */
class JSONResponse extends GenericResponse implements ArrayAccess
{
    /** @var array */
    private $data;

    /**
     * JSONResponse constructor.
     *`.
     *
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    /**
     * @param array $data
     */
    public static function respond(array $data = []): void
    {
        $response = new JSONResponse($data);
        $response->setHttpStatusCode(200);
        $response->output();
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->data);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet($offset)
    {
        if (!$this->offsetExists($offset)) {
            return null;
        }

        return $this->data[$offset];
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value)
    {
        $this->data[$offset] = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset)
    {
        if (!$this->offsetExists($offset)) {
            return;
        }

        unset($this->data[$offset]);
    }

    /**
     * @param array $_data
     *
     * @return JSONResponse
     */
    public function setData(array $_data): JSONResponse
    {
        $this->data = $_data;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    protected function responseBody()
    {
        return json_encode($this->data, JSON_THROW_ON_ERROR);
    }

    /**
     * {@inheritdoc}
     */
    protected function responseHeaders(): ?Headers
    {
        return new Headers([
            'Content-Type' => 'application/json'
        ]);
    }
}
