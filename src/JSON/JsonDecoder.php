<?php

namespace AntonioKadid\WAPPKitCore\JSON;

use AntonioKadid\WAPPKitCore\Exceptions\JSONException;
use AntonioKadid\WAPPKitCore\Text\Decoder;

/**
 * Class JsonDecoder
 *
 * @package AntonioKadid\WAPPKitCore\JSON
 */
class JsonDecoder extends Decoder
{
    /** @var bool */
    private $_assoc;
    /** @var int */
    private $_depth;
    /** @var int */
    private $_options;

    /**
     * JsonDecoder constructor.
     *
     * @param bool $assoc
     * @param int  $depth
     * @param int  $options
     */
    public function __construct($assoc = FALSE, $depth = 512, $options = 0)
    {
        $this->_assoc = $assoc;
        $this->_depth = $depth;
        $this->_options = $options;
    }

    /**
     * @param string $text
     * @param null   $default
     *
     * @return mixed
     *
     * @throws JSONException
     */
    public static function default(string $text, $default = NULL)
    {
        $instance = new JsonDecoder(TRUE);
        $result = $instance->decode($text, TRUE);

        return $result != NULL ? $result : $default;
    }

    /**
     * @inheritDoc
     *
     * @throws JSONException
     */
    public function decode(string $text, bool $silent = FALSE)
    {
        $this->error = '';
        $this->errorCode = JSON_ERROR_NONE;

        $decodedData = json_decode($text, $this->_assoc, $this->_depth, $this->_options);
        if ($decodedData !== FALSE && $decodedData !== NULL)
            return $decodedData;

        if (!function_exists('json_last_error'))
            return $this->handleError('Unable to decode JSON.', JSON_ERROR_NONE, $silent);

        $errorCode = json_last_error();
        if ($decodedData === NULL && ($errorCode === JSON_ERROR_NONE))
            return $this->handleError('Unable to decode JSON.', JSON_ERROR_NONE, $silent);

        $error = 'Unable to decode JSON.';
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