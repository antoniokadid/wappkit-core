<?php

namespace AntonioKadid\WAPPKitCore\Reflection;

use AntonioKadid\WAPPKitCore\Exceptions\InvalidParameterValueException;
use AntonioKadid\WAPPKitCore\Exceptions\UnknownParameterTypeException;
use ReflectionException;
use ReflectionNamedType;
use ReflectionParameter;

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
        if ($this->isDataKeyValuePairs) {
            return $values;
        }

        $keys = array_map(
            function (ReflectionParameter $parameter) {
                return $parameter->getName();
            },
            $reflectionParameters
        );

        $values = array_pad($values, count($keys), null);

        return array_combine($keys, $values);
    }

    /**
     * @param array $reflectionParameters
     * @param array $data
     *
     * @throws InvalidParameterValueException
     * @throws ReflectionException
     * @throws UnknownParameterTypeException
     *
     * @return array
     */
    protected function getInvokeArgs(array $reflectionParameters, array $data): array
    {
        $result = [];

        /** @var ReflectionParameter $reflectionParameter */
        foreach ($reflectionParameters as $reflectionParameter) {
            $parameterName = $reflectionParameter->getName();

            if (($class = $reflectionParameter->getClass()) != null) {
                $result[] = $this->getValueForClassParameter($reflectionParameter, $class->getName(), $data);
                continue;
            }

            if ($reflectionParameter->isArray() && is_array($data[$parameterName])) {
                $result[] = $data[$parameterName];
                continue;
            }

            if ($reflectionParameter->isCallable() && is_callable($data[$parameterName])) {
                $result[] = $data[$parameterName];
                continue;
            }

            if (
                !array_key_exists($parameterName, $data) ||
                ($reflectionParameter->isCallable() && !is_callable($data[$parameterName]))
            ) {
                if ($reflectionParameter->isOptional() && $reflectionParameter->isDefaultValueAvailable()) {
                    $result[] = $reflectionParameter->getDefaultValue();
                } elseif ($reflectionParameter->allowsNull()) {
                    $result[] = null;
                }

                throw new InvalidParameterValueException($parameterName, sprintf('Invalid value for parameter %s.', $parameterName));
            }

            $result[] = !$reflectionParameter->hasType() ?
                $data[$parameterName] :
                $this->getValueForTypedParameter($reflectionParameter, $data);
        }

        return $result;
    }

    /**
     * @param ReflectionParameter $parameter
     * @param callable            $callable
     * @param array               $data
     *
     * @throws InvalidParameterValueException
     * @throws ReflectionException
     * @throws UnknownParameterTypeException
     *
     * @return mixed
     */
    private function getValueForCallableParameter(ReflectionParameter $parameter, callable $callable, array $data)
    {
        $invoker = new CallableInvoker($callable);
        return $invoker->invoke($data, $this->isDataKeyValuePairs);
    }

    /**
     * @param ReflectionParameter $parameter
     * @param string              $className
     * @param array               $data
     *
     * @throws InvalidParameterValueException
     * @throws ReflectionException
     * @throws UnknownParameterTypeException
     *
     * @return mixed|object
     */
    private function getValueForClassParameter(ReflectionParameter $parameter, string $className, array $data)
    {
        $invoker  = new ConstructorInvoker($className);
        $instance = $invoker->invoke($data, $this->isDataKeyValuePairs);

        if ($instance === null) {
            if ($parameter->isOptional() && $parameter->isDefaultValueAvailable()) {
                return $parameter->getDefaultValue();
            }

            throw new UnknownParameterTypeException($parameter->getName(), sprintf('Unknown type for parameter %s', $parameter->getName()));
        }

        return $instance;
    }

    /**
     * @param ReflectionParameter $parameter
     * @param array               $data
     *
     * @throws InvalidParameterValueException
     * @throws ReflectionException
     * @throws UnknownParameterTypeException
     *
     * @return null|array|bool|float|int|mixed|string
     */
    private function getValueForTypedParameter(ReflectionParameter $parameter, array $data)
    {
        $parameterName  = $parameter->getName();
        $parameterType  = $parameter->getType();
        $parameterValue = $data[$parameterName];

        if (!($parameterType instanceof ReflectionNamedType)) {
            throw new UnknownParameterTypeException($parameterName, sprintf('Unknown type for parameter %s', $parameterName));
        }

        $parameterTypeName = $parameterType->getName();

        switch (strtolower($parameterTypeName)) {
            case 'string':
                return strval($parameterValue);
            case 'bool':
                return boolval($parameterValue);
            case 'int':
                return intval($parameterValue);
            case 'float':
                return floatval($parameterValue);
            default:
                throw new InvalidParameterValueException($parameterName, sprintf('Invalid value for parameter %s.', $parameterName));
        }
    }
}
