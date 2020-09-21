<?php

namespace AntonioKadid\WAPPKitCore\Exceptions;

use AntonioKadid\WAPPKitCore\Localization\ILanguage;
use Exception;
use Throwable;

/**
 * Class LocalizedException
 *
 * @package AntonioKadid\WAPPKitCore\Exceptions
 */
class LocalizedException extends Exception
{
    /** @var ILanguage */
    private $_language;

    /**
     * LocalizedException constructor.
     *
     * @param string         $message
     * @param int            $code
     * @param ILanguage|null $language
     * @param Throwable|null $previous
     */
    public function __construct($message = '', $code = 0, ILanguage $language = NULL, Throwable $previous = NULL)
    {
        parent::__construct($message, $code, $previous);

        $this->_language = $language;
    }

    /**
     * @return ILanguage
     */
    public function getLanguage(): ILanguage
    {
        return $this->_language;
    }
}