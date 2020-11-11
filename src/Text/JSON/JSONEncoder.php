<?php

namespace AntonioKadid\WAPPKitCore\Text\JSON;

use AntonioKadid\WAPPKitCore\Exceptions\EncodingException;
use AntonioKadid\WAPPKitCore\Text\Encoder;

/**
 * Class JSONEncoder.
 *
 * @package AntonioKadid\WAPPKitCore\Text\JSON
 */
class JSONEncoder extends Encoder
{
    /** @var int */
    private $depth;
    /** @var int */
    private $options;

    /**
     * JSONEncoder constructor.
     *
     * @param int $depth
     * @param int $options
     */
    public function __construct($depth = 512, $options = 0)
    {
        $this->depth   = $depth;
        $this->options = $options;
    }

    /**
     * @param      $data
     * @param null $default
     *
     * @throws EncodingException
     *
     * @return null|string
     */
    public static function default($data, $default = null): ?string
    {
        $instance = new JSONEncoder();
        $result   = $instance->encode($data, true);

        return $result != null ? $result : $default;
    }

    /**
     * {@inheritdoc}
     */
    public function encode($data, bool $silent = false): ?string
    {
        $this->error     = '';
        $this->errorCode = JSON_ERROR_NONE;

        $encodedData = json_encode($data, $this->options, $this->depth);
        if ($encodedData !== false) {
            return $encodedData;
        }

        if (!function_exists('json_last_error')) {
            return $this->handleError('Unable to encode JSON.', JSON_ERROR_NONE, $silent);
        }

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
     * @throws EncodingException
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

        throw new EncodingException($error, $code);
    }
}
