<?php

namespace AntonioKadid\WAPPKitCore\HTTP;

/**
 * Class Status
 *
 * @package AntonioKadid\WAPPKitCore\HTTP
 */
class Status
{
    /** The request has succeeded. */
    public const OK = 200;
    /** The request has succeeded and a new resource has been created as a result. */
    public const CREATED = 201;
    /** There is no content to send for this request, but the headers may be useful. */
    public const NO_CONTENT = 204;
    /** Tells the user-agent to reset the document which sent this request. */
    public const RESET_CONTENT = 205;
    /**
     * The URL of the requested resource has been changed permanently.
     * The new URL is given in the response.
     */
    public const MOVED_PERMANENTLY = 301;
    /**
     * This is used for caching purposes. It tells the client that the response has not been modified,
     * so the client can continue to use the same cached version of the response.
     */
    public const NOT_MODIFIED = 304;
    /** The server could not understand the request due to invalid syntax. */
    public const BAD_REQUEST = 400;
    /**
     * Although the HTTP standard specifies "unauthorized", semantically this response means "unauthenticated".
     * That is, the client must authenticate itself to get the requested response.
     */
    public const UNAUTHORIZED = 401;
    /**
     * The client does not have access rights to the content; that is, it is unauthorized, so the server
     * is refusing to give the requested resource. Unlike 401, the client's identity is known to the server.
     */
    public const FORBIDDEN = 403;
    /**
     * The server can not find the requested resource.
     * In the browser, this means the URL is not recognized.
     * In an API, this can also mean that the endpoint is valid but the resource itself does not exist.
     * Servers may also send this response instead of 403 to hide the existence of a resource
     * from an unauthorized client.
     */
    public const NOT_FOUND = 404;
    /**
     * The request method is known by the server but has been disabled and cannot be used.
     * For example, an API may forbid DELETE-ing a resource.
     * The two mandatory methods, GET and HEAD, must never be disabled and should not return this error code.
     */
    public const METHOD_NOT_ALLOWED = 405;
    /**
     * This response is sent when the web server, after performing server-driven content negotiation,
     * doesn't find any content that conforms to the criteria given by the user agent.
     */
    public const NOT_ACCEPTABLE = 406;
    /**
     * The server has encountered a situation it doesn't know how to handle.
     */
    public const INTERNAL_SERVER_ERROR = 500;
    /**
     * The request method is not supported by the server and cannot be handled.
     * The only methods that servers are required to support (and therefore that must not return this code) are
     * GET and HEAD.
     */
    public const NOT_IMPLEMENTED = 501;
    /**
     * The server is not ready to handle the request.
     * Common causes are a server that is down for maintenance or that is overloaded.
     * Note that together with this response, a user-friendly page explaining the problem should be sent.
     * This responses should be used for temporary conditions and the Retry-After: HTTP header should, if possible,
     * contain the estimated time before the recovery of the service.
     */
    public const SERVICE_UNAVAILABLE = 503;
}
