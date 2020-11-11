<?php

namespace AntonioKadid\WAPPKitCore\Text\JSON;

use AntonioKadid\WAPPKitCore\Exceptions\DecodingException;
use AntonioKadid\WAPPKitCore\Text\Decoder;

/**
 * Class JSONDecoder.
 *
 * @package AntonioKadid\WAPPKitCore\Text\JSON
 */
class JSONDecoder extends Decoder
{
    /** @var bool */
    private $assoc;
    /** @var int */
    private $depth;
    /** @var int */
    private $options;

    /**
     * JSONDecoder constructor.
     *
     * @param bool $assoc
     * @param int  $depth
     * @param int  $options
     */
    public function __construct($assoc = false, $depth = 512, $options = 0)
    {
        $this->assoc   = $assoc;
        $this->depth   = $depth;
        $this->options = $options;
    }

    /**
     * @param string $text
     * @param null   $default
     *
     * @throws DecodingException
     *
     * @return null|mixed
     */
    public static function default(string $text, $default = null)
    {
        $instance = new JSONDecoder(true);
        $result   = $instance->decode($text, true);

        return $result != null ? $result : $default;
    }

    /**
     * {@inheritdoc}
     */
    public function decode(string $text, bool $silent = false)
    {
        $this->error     = '';
        $this->errorCode = JSON_ERROR_NONE;

        $decodedData = json_decode($text, $this->assoc, $this->depth, $this->options);
        if ($decodedData !== false && $decodedData !== null) {
            return $decodedData;
        }

        if (!function_exists('json_last_error')) {
            return $this->handleError('Unable to decode JSON.', JSON_ERROR_NONE, $silent);
        }

        $errorCode = json_last_error();
        if ($decodedData === null && ($errorCode === JSON_ERROR_NONE)) {
            return $this->handleError('Unable to decode JSON.', JSON_ERROR_NONE, $silent);
        }

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
     * @throws DecodingException
     *
     * @return null|mixed
     */
    private function handleError(string $error, int $code, bool $silent)
    {
        $this->error     = $error;
        $this->errorCode = $code;

        if ($silent === true) {
            return null;
        }

        throw new DecodingException($error, $code);
    }
}
