<?php

namespace AntonioKadid\WAPPKitCore\Reflection;

use AntonioKadid\WAPPKitCore\Exceptions\InvalidArgumentException;
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
     *
     * @throws InvalidArgumentException
     * @throws UnknownParameterTypeException
     * @throws ReflectionException
     *
     * @return mixed
     */
    public function invoke(array $parameters = [])
    {
        $reflectionFunction = new ReflectionFunction($this->closure);
        if ($reflectionFunction->getNumberOfParameters() === 0) {
            return $reflectionFunction->invoke();
        }

        $reflectionParameters = $reflectionFunction->getParameters();
        $parameters           = $this->buildParameters($reflectionParameters, $parameters);

        $invokeArgs = $this->getInvokeArgs(
            $reflectionParameters,
            $parameters
        );

        return $reflectionFunction->invokeArgs($invokeArgs);
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
