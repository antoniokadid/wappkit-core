<?php

namespace AntonioKadid\WAPPKitCore\Reflection;

use AntonioKadid\WAPPKitCore\Exceptions\InvalidArgumentException;
use AntonioKadid\WAPPKitCore\Exceptions\UnknownParameterTypeException;
use ReflectionClass;
use ReflectionException;

/**
 * Class ConstructorInvoker.
 *
 * @package AntonioKadid\WAPPKitCore\Reflection
 */
class ConstructorInvoker extends Invoker implements IInvoker
{
    private $className;

    /**
     * ConstructorInvoker constructor.
     *
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->className = $name;
    }

    /**
     * @param array $parameters
     *
     * @throws InvalidArgumentException
     * @throws UnknownParameterTypeException
     * @throws ReflectionException
     *
     * @return null|mixed|object
     */
    public function invoke(array $parameters = [])
    {
        if (!class_exists($this->className, false)) {
            return null;
        }

        $class = new ReflectionClass($this->className);
        if (!$class->isInstantiable()) {
            return null;
        }

        $constructor = $class->getConstructor();

        if ($constructor == null || $constructor->getNumberOfParameters() === 0) {
            return $class->newInstance();
        }

        $constructorParameters = $constructor->getParameters();
        $parameters            = $this->buildParameters($constructorParameters, $parameters);

        return $class->newInstanceArgs(
            $this->getInvokeArgs(
                $constructorParameters,
                $parameters
            )
        );
    }

    /**
     * @param string $name
     *
     * @return $this|IInvoker
     */
    public function setClass(string $name): IInvoker
    {
        $this->className = $name;

        return $this;
    }
}
