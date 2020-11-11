<?php

namespace AntonioKadid\WAPPKitCore\Exceptions;

use AntonioKadid\WAPPKitCore\Localization\ILanguage;
use Exception;
use Throwable;

/**
 * Class LocalizedException.
 *
 * @package AntonioKadid\WAPPKitCore\Exceptions
 */
class LocalizedException extends Exception
{
    /** @var ILanguage */
    private $language;

    /**
     * LocalizedException constructor.
     *
     * @param string         $message
     * @param int            $code
     * @param null|ILanguage $language
     * @param null|Throwable $previous
     */
    public function __construct($message = '', $code = 0, ILanguage $language = null, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->language = $language;
    }

    /**
     * @return ILanguage
     */
    public function getLanguage(): ILanguage
    {
        return $this->language;
    }
}
