<?php

namespace AntonioKadid\WAPPKitCore\HTTP\Routing;

use AntonioKadid\WAPPKitCore\HTTP\Exceptions\ForbiddenException;
use AntonioKadid\WAPPKitCore\HTTP\Exceptions\MethodNotAllowedException;
use AntonioKadid\WAPPKitCore\HTTP\Exceptions\UnauthorizedException;
use Throwable;

/**
 * Class Route.
 *
 * @package AntonioKadid\WAPPKitCore\HTTP\Routing
 */
abstract class AbstractRouteHandler implements RouteHandlerInterface
{
    /** @var string */
    private $method;
    /** @var string */
    private $uri;
    /** @var array */
    private $uriParams;

    /**
     * @return bool
     */
    public function accessAllowed(): bool
    {
        return true;
    }

    /**
     * @return bool
     */
    public function authorized(): bool
    {
        return true;
    }

    /**
     * @param Throwable $throwable
     *
     * @throws Throwable
     */
    public function catch(Throwable $throwable): void
    {
        throw $throwable;
    }

    /**
     * {@inheritdoc}
     */
    public function follow(string $method, string $uri, array $uriParams)
    {
        $this->method    = $method;
        $this->uri       = $uri;
        $this->uriParams = $uriParams;

        try {
            if ($this->methodAllowed() !== true) {
                throw new MethodNotAllowedException($method, $uri);
            }

            if ($this->uriParametersValid() !== true) {
                return null;
            }

            if ($this->authorized() !== true) {
                throw new UnauthorizedException($method, $uri);
            }

            if ($this->accessAllowed() !== true) {
                throw new ForbiddenException($method, $uri);
            }

            return $this->doWork();
        } catch (Throwable $throwable) {
            $this->catch($throwable);
        }

        return null;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * @return array
     */
    public function getUriParams(): array
    {
        return $this->uriParams;
    }

    /**
     * {@inheritdoc}
     */
    public function methodAllowed(): bool
    {
        return true;
    }

    /**
     * @return bool
     */
    public function uriParametersValid(): bool
    {
        return true;
    }

    /**
     * @return mixed
     */
    abstract protected function doWork();
}
