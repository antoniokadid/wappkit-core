<?php

namespace AntonioKadid\WAPPKitCore\HTTP\Client;

use AntonioKadid\WAPPKitCore\HTTP\Exceptions\CURLException;
use AntonioKadid\WAPPKitCore\HTTP\Headers;
use AntonioKadid\WAPPKitCore\HTTP\Method;
use AntonioKadid\WAPPKitCore\HTTP\URL;

/**
 * Class CURL.
 *
 * @package AntonioKadid\WAPPKitCore\HTTP\Client
 */
class CURL
{
    public const CONTENT_TYPE_FORM_URLENCODED = 'application/x-www-form-urlencoded';
    public const CONTENT_TYPE_JSON            = 'application/json';

    /** @var false|resource */
    private $curlRef;

    /**
     * CURL constructor.
     */
    public function __construct()
    {
        $this->curlRef = curl_init();
    }

    public function __destruct()
    {
        $this->close();
    }

    public function close(): void
    {
        if (is_resource($this->curlRef)) {
            curl_close($this->curlRef);
        }
    }

    /**
     * @param URL              $url
     * @param array            $data
     * @param null|CURLOptions $options
     *
     * @throws CURLException
     *
     * @return CURLResult
     */
    public function delete(URL $url, array $data = [], ?CURLOptions $options = null): CURLResult
    {
        return $this->getLikeRequest(Method::DELETE, $url, $data, $options);
    }

    /**
     * Perform a GET request.
     *
     * @param URL              $url
     * @param array            $data
     * @param null|CURLOptions $options
     *
     * @throws CURLException
     *
     * @return CURLResult
     */
    public function get(URL $url, array $data = [], ?CURLOptions $options = null): CURLResult
    {
        return $this->getLikeRequest(Method::GET, $url, $data, $options);
    }

    /**
     * @param URL              $url
     * @param array            $data
     * @param null|CURLOptions $options
     *
     * @throws CURLException
     *
     * @return CURLResult
     */
    public function patch(URL $url, array $data = [], ?CURLOptions $options = null): CURLResult
    {
        return $this->postLikeRequest(Method::PATCH, $url, $data, $options);
    }

    /**
     * @param URL              $url
     * @param array            $data
     * @param null|CURLOptions $options
     *
     * @throws CURLException
     *
     * @return CURLResult
     */
    public function post(URL $url, array $data = [], ?CURLOptions $options = null): CURLResult
    {
        return $this->postLikeRequest(Method::POST, $url, $data, $options);
    }

    /**
     * @param URL              $url
     * @param array            $data
     * @param null|CURLOptions $options
     *
     * @throws CURLException
     *
     * @return CURLResult
     */
    public function put(URL $url, array $data = [], ?CURLOptions $options = null): CURLResult
    {
        return $this->postLikeRequest(Method::PUT, $url, $data, $options);
    }

    /**
     * @param null|CURLOptions $options
     *
     * @throws CURLException
     *
     * @return CURLResult
     */
    private function execute(?CURLOptions $options = null): CURLResult
    {
        if ($options != null) {
            $options->setup($this->curlRef);
        }

        curl_setopt($this->curlRef, CURLOPT_HEADER, 1);
        curl_setopt($this->curlRef, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($this->curlRef);

        if (curl_errno($this->curlRef) !== 0) {
            throw new CURLException(curl_error($this->curlRef), curl_errno($this->curlRef));
        }

        $code        = curl_getinfo($this->curlRef, CURLINFO_RESPONSE_CODE);
        $headersSize = curl_getinfo($this->curlRef, CURLINFO_HEADER_SIZE);

        $responseHeaders = Headers::fromString(substr($response, 0, $headersSize));
        $responseBody    = substr($response, $headersSize);

        return new CURLResult($code, $responseHeaders, $responseBody);
    }

    /**
     * @param string           $method
     * @param URL              $url
     * @param array            $data
     * @param null|CURLOptions $options
     *
     * @throws CURLException
     *
     * @return CURLResult
     */
    private function getLikeRequest(string $method, URL $url, array $data = [], ?CURLOptions $options = null)
    {
        $url->query = !is_array($url->query) ? $data : array_merge($url->query, $data);

        curl_setopt($this->curlRef, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($this->curlRef, CURLOPT_URL, $url->__toString());

        return $this->execute($options);
    }

    /**
     * @param string           $method
     * @param URL              $url
     * @param array            $data
     * @param null|CURLOptions $options
     *
     * @throws CURLException
     *
     * @return CURLResult
     */
    private function postLikeRequest(
        string $method,
        URL $url,
        array $data = [],
        ?CURLOptions $options = null
    ): CURLResult {
        if ($options == null) {
            $options = new CURLOptions();
        }

        if ($options->headers == null) {
            $options->headers = new Headers();
        }

        if ($options->headers->getTrimString(Headers::CONTENT_TYPE) === self::CONTENT_TYPE_JSON) {
            $postData = json_encode($data, JSON_THROW_ON_ERROR);

            curl_setopt($this->curlRef, CURLOPT_POSTFIELDS, $postData);

            $options->headers[Headers::CONTENT_LENGTH] = strlen($postData);
        } else {
            $query = http_build_query($data);

            curl_setopt($this->curlRef, CURLOPT_POSTFIELDS, $query);

            $options->headers[Headers::CONTENT_TYPE]   = self::CONTENT_TYPE_FORM_URLENCODED;
            $options->headers[Headers::CONTENT_LENGTH] = strlen($query);
        }

        curl_setopt($this->curlRef, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($this->curlRef, CURLOPT_URL, $url->__toString());

        return $this->execute($options);
    }
}
