<?php

namespace AntonioKadid\WAPPKitCore\Reflection;

use AntonioKadid\WAPPKitCore\Exceptions\InvalidParameterValueException;
use AntonioKadid\WAPPKitCore\Exceptions\UnknownParameterTypeException;
use Closure;
use ReflectionException;
use ReflectionFunction;

/**
 * Class ClosureInvoker.
 *
 * @package AntonioKadid\WAPPKitCore\Reflection
 */
class ClosureInvoker extends Invoker implements IInvoker
{
    /** @var Closure */
    private $closure;

    /**
     * ClosureInvoker constructor.
     *
     * @param Closure $closure
     */
    public function __construct(Closure $closure)
    {
        $this->setClosure($closure);
    }

    /**
     * @param array $parameters
     * @param bool  $keyValuePairs true, if the $parameters is a key-value pair array else False
     *
     * @throws InvalidParameterValueException
     * @throws UnknownParameterTypeException
     * @throws ReflectionException
     *
     * @return mixed
     */
    public function invoke(array $parameters = [], bool $keyValuePairs = true)
    {
        $this->isDataKeyValuePairs = $keyValuePairs;

        $reflectionFunction = new ReflectionFunction($this->closure);
        if ($reflectionFunction->getNumberOfParameters() === 0) {
            return $reflectionFunction->invoke();
        }

        $reflectionParameters = $reflectionFunction->getParameters();
        $parameters           = $this->buildParameters($reflectionParameters, $parameters);

        return $reflectionFunction->invokeArgs(
            $this->getInvokeArgs(
                $reflectionParameters,
                $parameters
            )
        );
    }

    /**
     * @param Closure $closure
     *
     * @return $this|IInvoker
     */
    public function setClosure(Closure $closure): IInvoker
    {
        $this->closure = $closure;

        return $this;
    }
}
