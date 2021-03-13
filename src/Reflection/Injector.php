<?php

namespace AntonioKadid\WAPPKitCore\Reflection;

use AntonioKadid\WAPPKitCore\Exceptions\InvalidArgumentException;
use AntonioKadid\WAPPKitCore\Exceptions\UnknownParameterTypeException;
use Closure;
use ReflectionClass;
use ReflectionFunction;
use ReflectionParameter;

class Injector
{
    private static array $injectables = [];

    public static function inject(string | Closure | callable $input, array $data): mixed
    {
        if (is_string($input) && class_exists($input)) {
            return self::injectClass($input, $data);
        } elseif (is_string($input) && is_callable($input)) {
            return self::injectClosure(Closure::fromCallable($input), $data);
        } elseif ($input instanceof Closure) {
            return self::injectClosure($input, $data);
        } elseif (is_callable($input)) {
            return self::injectClosure(Closure::fromCallable($input), $data);
        }

        return null;
    }

    /**
     * Register a class instance.
     *
     * @param string $className
     * @param mixed  $classInstance
     */
    public static function register(string $className, mixed $classInstance): void
    {
        if (array_key_exists($className, self::$injectables)) {
            return;
        }

        self::$injectables[$className] = $classInstance;
    }

    /**
     * @param ReflectionParameter[] $reflectionParameters
     * @param mixed[]               $data
     *
     * @throws InvalidArgumentException
     * @throws ReflectionException
     * @throws UnknownParameterTypeException
     *
     * @return mixed[]
     */
    private static function getInvokeArgs(array $reflectionParameters, array $data): array
    {
        $result = [];

        foreach ($reflectionParameters as $reflectionParameter) {
            $injectableParameter                     = new InjectableParameter($reflectionParameter);
            $result[$reflectionParameter->getName()] = $injectableParameter->injectData($data);
        }

        return $result;
    }

    private static function injectClass(string $className, array $data): mixed
    {
        $class = new ReflectionClass($className);
        if (!$class->isInstantiable()) {
            return null;
        }

        $constructor = $class->getConstructor();
        if ($constructor == null || $constructor->getNumberOfParameters() === 0) {
            return $class->newInstance();
        }

        $constructorParams = $constructor->getParameters();
        $injectionParams   = self::prepareParametersForInjection($constructorParams, $data);
        $instanceArgs      = self::getInvokeArgs($constructorParams, $injectionParams);

        return $class->newInstanceArgs($instanceArgs);
    }

    private static function injectClosure(Closure $closure, array $data): mixed
    {
        $reflectionFunction = new ReflectionFunction($closure);

        if ($reflectionFunction->getNumberOfParameters() === 0) {
            return $reflectionFunction->invoke();
        }

        $reflectionParams = $reflectionFunction->getParameters();
        $injectionParams  = self::prepareParametersForInjection($reflectionParams, $data);
        $invokeArgs       = self::getInvokeArgs($reflectionParams, $injectionParams);

        return $reflectionFunction->invokeArgs($invokeArgs);
    }

    /**
     * @param ReflectionParameter[] $reflectionParameters
     * @param array                 $parameterValues
     *
     * @return array
     */
    private static function prepareParametersForInjection(array $reflectionParameters, array $parameterValues): array
    {
        $parameterNames = array_map(
            fn(ReflectionParameter $parameter) => $parameter->getName(),
            $reflectionParameters
        );

        $result          = [];
        $parameterValues = array_pad($parameterValues, count($parameterNames), null);

        // Assing to named parameters values that are already defined with the same name.
        foreach ($parameterNames as $parameterName) {
            if (array_key_exists($parameterName, $parameterValues)) {
                $result[$parameterName] = $parameterValues[$parameterName];
                unset($parameterValues[$parameterName]);
            }
        }

        // For the remaining named parameters a value by the order of appearance.
        $parameterNamesNotProcessed = array_diff($parameterNames, array_keys($result));
        foreach ($parameterNamesNotProcessed as $parameterName) {
            $result[$parameterName] = array_shift($parameterValues);
        }

        return $result;
    }
}
