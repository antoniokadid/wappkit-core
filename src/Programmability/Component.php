<?php

namespace AntonioKadid\WAPPKitCore\Programmability;

/**
 * Class Component.
 *
 * @package AntonioKadid\WAPPKitCore\Programmability
 */
class Component
{
    /** @var null|string */
    private $className;
    /** @var string */
    private $content;
    /** @var null|ExecutionContext */
    private $context;
    /** @var string */
    private $name;
    /** @var array */
    private $parameters;

    /**
     * Component constructor.
     *
     * @param string                $name
     * @param array                 $parameters
     * @param string                $content
     * @param null|ExecutionContext $context
     */
    public function __construct(string $name, string $content = '', array $parameters = [], ExecutionContext $context = null)
    {
        $this->name       = $name;
        $this->content    = $content;
        $this->className  = $this->generateClassName();
        $this->parameters = $parameters;
        $this->context    = $context;
    }

    /**
     * @return null|string
     */
    public function getClassName(): ?string
    {
        return $this->className;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @return null|ExecutionContext
     */
    public function getContext(): ?ExecutionContext
    {
        return $this->context;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * @param null|ExecutionContext $context
     */
    public function setContext(?ExecutionContext $context): void
    {
        $this->context = $context;
    }

    /**
     * @param array $parameters
     */
    public function setParameters(array $parameters): void
    {
        $this->parameters = $parameters;
    }

    /**
     * @return null|string
     */
    private function extractClassName(): ?string
    {
        if (empty($this->content)) {
            return null;
        }

        if (!preg_match('/\s*class\s+([^\s\{]*)/i', $this->content, $matches)) {
            return null;
        }

        return $matches[1];
    }

    /**
     * @return null|string
     */
    private function extractNamespace(): ?string
    {
        if (empty($this->content)) {
            return null;
        }

        if (!preg_match('/\s*namespace\s+([^\s;]*);/i', $this->content, $matches)) {
            return null;
        }

        return $matches[1];
    }

    /**
     * @return null|string
     */
    private function generateClassName(): ?string
    {
        $namespace = $this->extractNamespace();
        $className = $this->extractClassName();

        if ($className == null) {
            return null;
        }

        if ($namespace == null) {
            return "\\{$className}";
        }

        return "\\{$namespace}\\{$className}";
    }
}
