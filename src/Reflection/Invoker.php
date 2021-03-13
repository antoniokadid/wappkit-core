<?php

namespace AntonioKadid\WAPPKitCore\Reflection;

use AntonioKadid\WAPPKitCore\Exceptions\InvalidArgumentException;
use AntonioKadid\WAPPKitCore\Exceptions\UnknownParameterTypeException;
use ReflectionNamedType;
use ReflectionParameter;
use ReflectionUnionType;

/**
 * Class Invoker.
 *
 * @package AntonioKadid\WAPPKitCore\Reflection
 */
class Invoker
{
    protected $isDataKeyValuePairs;

    /**
     * @param ReflectionParameter[] $reflectionParameters
     * @param array                 $values
     *
     * @return array
     */
    protected function buildParameters(array $reflectionParameters, array $values): array
    {
        $keys = array_map(
            fn(ReflectionParameter $parameter) => $parameter->getName(),
            $reflectionParameters
        );

        $result = [];
        $values = array_pad($values, count($keys), null);

        // Assing to named parameters values that are already defined with the same name.
        foreach ($keys as $key) {
            if (array_key_exists($key, $values)) {
                $result[$key] = $values[$key];
                unset($values[$key]);
            }
        }

        // For the remaining named parameters a value by the order of appearance.
        $keysNotProcessed = array_diff($keys, array_keys($result));
        foreach ($keysNotProcessed as $key) {
            $result[$key] = array_shift($values);
        }

        return $result;
    }

    /**
     * @param ReflectionParameter[] $reflectionParameters
     * @param array                 $data
     *
     * @throws InvalidArgumentException
     * @throws ReflectionException
     * @throws UnknownParameterTypeException
     *
     * @return array
     */
    protected function getInvokeArgs(array $reflectionParameters, array $data): array
    {
        $result = [];

        foreach ($reflectionParameters as $reflectionParameter) {
            $result[$reflectionParameter->getName()] = $this->processParameter($reflectionParameter, $data);
        }

        return $result;
    }

    /**
     * @param string $parameterName
     * @param bool   $nullable
     * @param bool   $canUseDefaultValue
     * @param mixed  $defaultValue
     *
     * @throws InvalidArgumentException
     */
    private function defaultValueOrThrowInvalidType($parameterName, $nullable, $canUseDefaultValue, $defaultValue)
    {
        if ($canUseDefaultValue) {
            return $defaultValue;
        }

        if ($nullable) {
            return null;
        }

        throw new UnknownParameterTypeException($parameterName, sprintf('Unknown type for parameter %s', $parameterName));
    }

    /**
     * @param string $parameterName
     * @param bool   $nullable
     * @param bool   $canUseDefaultValue
     * @param mixed  $defaultValue
     *
     * @throws InvalidArgumentException
     */
    private function defaultValueOrThrowInvalidValue($parameterName, $nullable, $canUseDefaultValue, $defaultValue)
    {
        if ($canUseDefaultValue) {
            return $defaultValue;
        }

        if ($nullable) {
            return null;
        }

        throw new InvalidArgumentException($parameterName, sprintf('Invalid value for parameter %s.', $parameterName));
    }

    /**
     * @param string $parameterName
     * @param string $parameterType
     * @param mixed  $parameterValue
     * @param bool   $nullable
     * @param bool   $canUseDefaultValue
     * @param mixed  $defaultValue
     *
     * @throws InvalidArgumentException
     */
    private function handleBuiltinType(
        string $parameterName,
        string $parameterType,
        $parameterValue,
        bool $nullable,
        bool $canUseDefaultValue,
        $defaultValue
    ): null | string | bool | int | float | array {
        switch (strtolower($parameterType)) {
            case 'string':
                return strval($parameterValue);
            case 'bool':
                return boolval($parameterValue);
            case 'int':
                return intval($parameterValue);
            case 'float':
                return floatval($parameterValue);
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

                // intentional fallback to default if array wasn't parsed.
            default:
                return $this->defaultValueOrThrowInvalidValue($parameterName, $nullable, $canUseDefaultValue, $defaultValue);
        }
    }

    /**
     * @param string $parameterName
     * @param string $parameterType
     * @param mixed  $parameterValue
     * @param bool   $nullable
     * @param bool   $canUseDefaultValue
     * @param mixed  $defaultValue
     *
     * @throws UnknownParameterTypeException
     *
     * @return mixed
     */
    private function handleCallable(
        string $parameterName,
        string $parameterType,
        $parameterValue,
        bool $nullable,
        bool $canUseDefaultValue,
        $defaultValue
    ) {
        $invoker = new ClosureInvoker(\Closure::fromCallable($parameterValue));
        return $invoker->invoke([$parameterName => $parameterValue]);
    }

    /**
     * @param string $parameterName
     * @param string $parameterType
     * @param mixed  $parameterValue
     * @param bool   $nullable
     * @param bool   $canUseDefaultValue
     * @param mixed  $defaultValue
     *
     * @throws UnknownParameterTypeException
     *
     * @return mixed
     */
    private function handleClass(
        string $parameterName,
        string $parameterType,
        $parameterValue,
        bool $nullable,
        bool $canUseDefaultValue,
        $defaultValue
    ) {
        $invoker       = new ConstructorInvoker($parameterType);
        $classInstance = $invoker->invoke([$parameterName => $parameterValue]);

        if ($classInstance === null) {
            return $this->defaultValueOrThrowInvalidType($parameterName, $nullable, $canUseDefaultValue, $defaultValue);
        }

        return $classInstance;
    }

    private function processParameter(ReflectionParameter $reflectionParameter, array $data)
    {
        $parameterName  = $reflectionParameter->getName();
        $parameterType  = $reflectionParameter->getType();
        $parameterValue = $data[$parameterName];

        if ($parameterType == null) {
            return $parameterValue;
        }

        $nullable              = $parameterType->allowsNull();
        $defaultValueAvailable = $reflectionParameter->isOptional() && $reflectionParameter->isDefaultValueAvailable();
        $defaultValue          = $defaultValueAvailable ? $reflectionParameter->getDefaultValue() : null;

        if ($parameterType instanceof ReflectionUnionType) {
            if ($defaultValueAvailable) {
                return $defaultValue;
            }

            if ($nullable) {
                return null;
            }

            throw new UnknownParameterTypeException($parameterName, sprintf('Unsupported union type detected for parameter %s.', $parameterName));
        }

        if (!($parameterType instanceof ReflectionNamedType)) {
            return $this->defaultValueOrThrowInvalidType($parameterName, $nullable, $defaultValueAvailable, $defaultValue);
        }

        $parameterTypeName = $parameterType->getName();

        if ($parameterTypeName === 'callable' && is_callable($parameterValue)) {
            return $parameterValue; // $this->handleCallable($parameterName, $parameterTypeName, $parameterValue, $nullable, $defaultValueAvailable, $defaultValue);
        }

        if ($parameterType->isBuiltin()) {
            return $this->handleBuiltinType($parameterName, $parameterTypeName, $parameterValue, $nullable, $defaultValueAvailable, $defaultValue);
        }

        if (class_exists($parameterType)) {
            return $this->handleClass($parameterName, $parameterTypeName, $parameterValue, $nullable, $defaultValueAvailable, $defaultValue);
        }

        return $this->defaultValueOrThrowInvalidType($parameterName, $nullable, $defaultValueAvailable, $defaultValue);
    }
}
