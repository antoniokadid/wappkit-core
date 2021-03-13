<?php

namespace AntonioKadid\WAPPKitCore\Reflection;

use AntonioKadid\WAPPKitCore\Exceptions\InvalidArgumentException;
use AntonioKadid\WAPPKitCore\Exceptions\UnknownParameterTypeException;
use ReflectionNamedType;
use ReflectionParameter;
use ReflectionUnionType;

class InjectableParameter
{
    private bool $allowsDefaultValue     = false;
    private bool $builtIn                = false;
    private mixed $defaultValue;
    private bool $nullable               = false;
    private string $parameterName;
    private string | null $parameterType = null;
    private bool $unionType              = false;

    public function __construct(ReflectionParameter $reflectionParameter)
    {
        $this->parameterName = $reflectionParameter->getName();
        $this->nullable  = $reflectionParameter->allowsNull();

        $parameterType       = $reflectionParameter->getType();

        $this->unionType = ($parameterType instanceof ReflectionUnionType);

        if ($parameterType instanceof ReflectionNamedType) {
            $this->unionType     = false;
            $this->parameterType = $parameterType->getName();
            $this->builtIn       = $parameterType->isBuiltin();
        }

        $this->allowsDefaultValue = $reflectionParameter->isOptional() && $reflectionParameter->isDefaultValueAvailable();
        if ($this->allowsDefaultValue) {
            $this->defaultValue = $reflectionParameter->getDefaultValue();
        }
    }

    public function injectData(array $data): mixed
    {
        if (!array_key_exists($this->parameterName, $data)) {
            return $this->defaultValueOrThrowInvalidValue('Missing value.');
        }

        $parameterValue = $data[$this->parameterName];

        if ($this->parameterType === null) {
            return $parameterValue;
        }

        if ($this->unionType) {
            return $this->defaultValueOrThrowInvalidType('Unable to handle union types.');
        }

        if ($this->builtIn) {
            return $this->handleBuiltinType($parameterValue);
        }

        if ($this->parameterType === 'callable' && is_callable($parameterValue)) {
            return $parameterValue;
        }

        if (class_exists($this->parameterType)) {
            return Injector::inject($this->parameterType, ["{$this->parameterName}" => $parameterValue]) ??
                    $this->defaultValueOrThrowInvalidType('');
        }

        return $this->defaultValueOrThrowInvalidType('Unable to handle parameter.');
    }

    /**
     * @throws InvalidArgumentException
     */
    private function defaultValueOrThrowInvalidType(string $message): mixed
    {
        if ($this->allowsDefaultValue) {
            return $this->defaultValue;
        }

        if ($this->nullable) {
            return null;
        }

        throw new UnknownParameterTypeException($this->parameterName, $message);
    }

    /**
     * @throws InvalidArgumentException
     */
    private function defaultValueOrThrowInvalidValue(string $message): mixed
    {
        if ($this->allowsDefaultValue) {
            return $this->defaultValue;
        }

        if ($this->nullable) {
            return null;
        }

        throw new InvalidArgumentException($this->parameterName, $message);
    }

    /**
     * @throws InvalidArgumentException
     */
    private function handleBuiltinType(mixed $parameterValue): null | string | bool | int | float | array
    {
        switch (strtolower($this->parameterType)) {
            case 'string':
                return strval($parameterValue);
            case 'bool':
                return boolval($parameterValue);
            case 'int':
                return intval($parameterValue);
            case 'float':
                return floatval($parameterValue);
            case 'callable':
                if (is_callable($parameterValue)) {
                    return $parameterValue;
                }

                break;
            case 'array':
                if (is_array($parameterValue)) {
                    return $parameterValue;
                }

                if (is_string($parameterValue)) {
                    $result = preg_split('/\s+/', $parameterValue);
                    if (is_array($result)) {
                        return $result;
                    }
                }

                break;
            default:
                break;
        }

        return $this->defaultValueOrThrowInvalidValue(sprintf('Unable to handle builtin type %s.', $this->parameterType));
    }
}
