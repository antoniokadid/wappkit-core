<?php

namespace AntonioKadid\WAPPKitCore\HTTP\Routing;

use AntonioKadid\WAPPKitCore\HTTP\Exceptions\ForbiddenException;
use AntonioKadid\WAPPKitCore\HTTP\Exceptions\MethodNotAllowedException;
use AntonioKadid\WAPPKitCore\HTTP\Exceptions\NotImplementedException;
use AntonioKadid\WAPPKitCore\HTTP\Exceptions\UnauthorizedException;
use Throwable;

/**
 * Class RouteHandler.
 *
 * @package AntonioKadid\WAPPKitCore\HTTP\Routing
 */
class RouteHandler implements RouteHandlerInterface
{
    /** @var string */
    private $method;
    /** @var array */
    private $parameters;
    /** @var string */
    private $uri;

    /**
     * {@inheritdoc}
     */
    final public function follow(string $method, string $uri, array $parameters)
    {
        $this->method     = $method;
        $this->uri        = $uri;
        $this->parameters = $parameters;

        try {
            if ($this->methodAllowed() !== true) {
                throw new MethodNotAllowedException($method, $uri, $parameters);
            }

            if ($this->validate() !== true) {
                return null;
            }

            if ($this->authorized() !== true) {
                throw new UnauthorizedException($method, $uri, $parameters);
            }

            if ($this->accessAllowed() !== true) {
                throw new ForbiddenException($method, $uri, $parameters);
            }

            return $this->work();
        } catch (Throwable $throwable) {
            $this->catch($throwable);
        }

        return null;
    }

    /**
     * @return string
     */
    final public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return array
     */
    final public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * @return string
     */
    final public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * @return bool
     */
    protected function accessAllowed(): bool
    {
        return true;
    }

    /**
     * @return bool
     */
    protected function authorized(): bool
    {
        return true;
    }

    /**
     * @param Throwable $throwable
     *
     * @throws Throwable
     */
    protected function catch(Throwable $throwable): void
    {
        throw $throwable;
    }

    /**
     * @return bool
     */
    protected function methodAllowed(): bool
    {
        return true;
    }

    /**
     * @return bool
     */
    protected function validate(): bool
    {
        return true;
    }

    /**
     * @return mixed
     */
    protected function work()
    {
        throw new NotImplementedException($this->method, $this->uri, $this->parameters);
    }
}
