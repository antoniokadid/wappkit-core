<?php

namespace AntonioKadid\WAPPKitCore\Text\Sanitizers;

/**
 * Class VariableNameSanitizer.
 *
 * @package AntonioKadid\WAPPKitCore\Text\Sanitizers
 */
class VariableNameSanitizer implements SanitizerInterface
{
    /** @var string */
    private $text;
    /** @var string */
    private $replacement;

    /**
     * @param string $text
     * @param string $replacement
     */
    public function __construct(string $text = '', string $replacement = '')
    {
        $this->text       = $text;
        $this->replacement = $replacement;
    }

    /**
     * @return string
     */
    public function sanitize(): string
    {
        return preg_replace('/[^a-zA-Z0-9_\x80-\xff]/', $this->replacement, $this->text) ?? $this->text;
    }

    /**
     * @param string $text
     *
     * @return VariableNameSanitizer
     */
    public function setText(string $text): VariableNameSanitizer
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @param string $replacement
     *
     * @return VariableNameSanitizer
     */
    public function setReplacement(string $replacement): VariableNameSanitizer
    {
        $this->replacement = $replacement;

        return $this;
    }
}
