<?php

namespace TochkaApi;


use TochkaApi\Auth\AccessToken;
use TochkaApi\Auth\BearerAuth;
use TochkaApi\HttpAdapters\HttpClientInterface;
use TochkaApi\Models\Consent;

/**
 * Class Api
 * @package TochkaApi
 */
class Api
{
    /**
     * @var string HOST
     */
    const HOST = "https://enter.tochka.com";

    /**
     * @var string VERSION
     */
    const VERSION = "v1.0";

    /**
     * @var HttpClientInterface $adapter
     */
    protected $adapter;

    /**
     * @var array $headers
     */
    protected $headers = [];

    /**
     * @var array $bearerAuthHeader
     */
    protected $bearerAuthHeader = [];

    /**
     * Api constructor.
     * @param AccessToken $token
     * @param HttpClientInterface $adapter
     */
    public function __construct(AccessToken $token, HttpClientInterface $adapter)
    {
        $bearerAuth = new BearerAuth($token);

        $this->setBearerAuthHeader($bearerAuth->getHeaders());

        $this->setAdapter($adapter);
    }

    /**
     * @return HttpClientInterface
     */
    protected function getAdapter()
    {
        return $this->adapter;
    }

    /**
     * @param HttpClientInterface $adapter
     */
    protected function setAdapter(HttpClientInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers + $this->getBearerAuthHeader();
    }

    /**
     * @param array $headers
     */
    public function setHeaders(array $headers)
    {
        $this->headers = $headers;
    }

    /**
     * @return array
     */
    protected function getBearerAuthHeader()
    {
        return $this->bearerAuthHeader;
    }

    /**
     * @param array $bearerAuthHeader
     */
    protected function setBearerAuthHeader($bearerAuthHeader)
    {
        $this->bearerAuthHeader = $bearerAuthHeader;
    }

    /**
     * @param string $type
     * @return string
     */
    protected function getBaseUrl($type)
    {
        return static::HOST . "/uapi/" . $type . "/" . static::VERSION;
    }

    /**
     * @param string $type
     * @param string $instance
     * @param string ...$parameters
     * @return string
     */
    protected function getEndpoint($type, $instance, ...$parameters)
    {
        $parameters = array_filter($parameters);

        $parametersData = [];

        array_walk_recursive($parameters, function ($item, $key) use (&$parametersData) {
            $parametersData[] = $item;
        });

        return trim($this->getBaseUrl($type) . "/" . $instance . "/" . (!empty($parametersData) ? implode("/", $parametersData) : ""), "/");
    }

    /**
     * @param $method
     * @param $url
     * @param array $data
     * @return array
     */
    public function apiRequest($method, $url, $data = [])
    {
        $response = $this->getAdapter()->request(
            $method,
            $url,
            json_encode($data),
            $this->getHeaders()
        );

        return $response->getArray();
    }

    /**
     * @param $method
     * @param $type
     * @param $instance
     * @param array $data
     * @param mixed ...$parameters
     * @return array
     */
    public function call($method, $type, $instance, $data = [], ...$parameters)
    {
        return $this->apiRequest($method, $this->getEndpoint($type, $instance, $parameters), $data);
    }

    /**
     * @param $data
     * @return array
     */
    public function permissionsRequest($data)
    {
        return (new Consent($this))->create($data);
    }
}