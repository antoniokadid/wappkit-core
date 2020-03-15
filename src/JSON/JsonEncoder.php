<?php

namespace AntonioKadid\WAPPKitCore\JSON;

use AntonioKadid\WAPPKitCore\Exceptions\JSONException;
use AntonioKadid\WAPPKitCore\Text\Encoder;

/**
 * Class JsonEncoder
 *
 * @package AntonioKadid\WAPPKitCore\JSON
 */
class JsonEncoder extends Encoder
{
    /** @var int */
    private $_depth;
    /** @var int */
    private $_options;

    /**
     * JsonEncoder constructor.
     *
     * @param int $depth
     * @param int $options
     */
    public function __construct($depth = 512, $options = 0)
    {
        $this->_depth = $depth;
        $this->_options = $options;
    }

    /**
     * @param mixed $data
     * @param null  $default
     *
     * @return string|null
     *
     * @throws JSONException
     */
    public static function default($data, $default = NULL): ?string
    {
        $instance = new JsonEncoder();
        $result = $instance->encode($data, TRUE);

        return $result != NULL ? $result : $default;
    }

    /**
     * @inheritDoc
     *
     * @throws JSONException
     */
    public function encode($data, bool $silent = FALSE): ?string
    {
        $this->error = '';
        $this->errorCode = JSON_ERROR_NONE;

        $encodedData = json_encode($data, $this->_options, $this->_depth);
        if ($encodedData !== FALSE)
            return $encodedData;

        if (!function_exists('json_last_error'))
            return $this->handleError('Unable to encode JSON.', JSON_ERROR_NONE, $silent);

        $errorCode = json_last_error();

        $error = 'Unable to encode JSON.';
        switch ($errorCode) {
            case JSON_ERROR_DEPTH:
                $error .= ' The maximum stack depth has been exceeded.';
                break;
            case JSON_ERROR_STATE_MISMATCH:
                $error .= ' Underflow or mode mismatch.';
                break;
            case JSON_ERROR_CTRL_CHAR:
                $error .= ' Control character error, possibly incorrectly encoded.';
                break;
            case JSON_ERROR_SYNTAX:
                $error .= ' Syntax error.';
                break;
            case JSON_ERROR_UTF8:
                $error .= ' Malformed UTF-8 characters, possibly incorrectly encoded.';
                break;
            default:
                $error .= ' Unknown error.';
                break;
        }

        return $this->handleError($error, $errorCode, $silent);
    }

    /**
     * @param string $error
     * @param int    $code
     * @param bool   $silent
     *
     * @return mixed
     *
     * @throws JSONException
     */
    private function handleError(string $error, int $code, bool $silent)
    {
        $this->error = $error;
        $this->errorCode = $code;

        if ($silent === TRUE)
            return NULL;

        throw new JSONException($error, $code);
    }
}