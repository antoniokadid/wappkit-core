<?php

namespace AntonioKadid\WAPPKitCore\HTTP;

/**
 * Class Method
 *
 * @package AntonioKadid\WAPPKitCore\HTTP
 *
 * @url https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods
 */
class Method
{
    /**
     * The GET method requests a representation of the specified resource. Requests using GET should only retrieve data.
     */
    public const GET = 'GET';
    /**
     * The HEAD method asks for a response identical to that of a GET request, but without the response body.
     */
    public const HEAD = 'HEAD';
    /**
     * The POST method is used to submit an entity to the specified resource, often causing a change in state or side
     * effects on the server.
     */
    public const POST = 'POST';
    /**
     * The PUT method replaces all current representations of the target resource with the request payload.
     */
    public const PUT = 'PUT';
    /**
     * The DELETE method deletes the specified resource.
     */
    public const DELETE = 'DELETE';
    /**
     * The CONNECT method establishes a tunnel to the server identified by the target resource.
     */
    public const CONNECT = 'CONNECT';
    /**
     * The OPTIONS method is used to describe the communication options for the target resource.
     */
    public const OPTIONS = 'OPTIONS';
    /**
     * The TRACE method performs a message loop-back test along the path to the target resource.
     */
    public const TRACE = 'TRACE';
    /**
     * The PATCH method is used to apply partial modifications to a resource.
     */
    public const PATCH = 'PATCH';
}
