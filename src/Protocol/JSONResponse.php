<?php

namespace AntonioKadid\WAPPKitCore\Protocol;

use AntonioKadid\WAPPKitCore\HTTP\Headers;
use AntonioKadid\WAPPKitCore\Text\Exceptions\EncodingException;
use AntonioKadid\WAPPKitCore\Text\JSON\JSONEncoder;
use ArrayAccess;

/**
 * Class JSONResponse
 *
 * @package AntonioKadid\WAPPKitCore\Protocol
 */
class JSONResponse extends GenericResponse implements ArrayAccess
{
    /** @var array */
    private $_data;

    /**
     * JSONResponse constructor.
     *`
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->_data = $data;
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
     * @param array $_data
     *
     * @return JSONResponse
     */
    public function setData(array $_data): JSONResponse
    {
        $this->_data = $_data;

        return $this;
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

    /**
     * @inheritDoc
     */
    protected function responseHeaders(): ?Headers
    {
        return new Headers([
            'Content-Type' => 'application/json'
        ]);
    }

    /**
     * @inheritDoc
     *
     * @throws EncodingException
     */
    protected function responseBody()
    {
        $encoder = new JSONEncoder();

        return $encoder->encode($this->_data);
    }
}