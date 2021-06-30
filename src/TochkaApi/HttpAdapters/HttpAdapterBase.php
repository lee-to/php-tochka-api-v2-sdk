<?php

namespace TochkaApi\HttpAdapters;

use TochkaApi\Auth\AccessToken;
use TochkaApi\Responses\RawResponse;

/**
 * Class HttpAdapterBase
 * @package TochkaApi\HttpAdapters
 */
abstract class HttpAdapterBase
{
    /**
     * @var
     */
    protected $client;

    /**
     * HttpAdapterBase constructor.
     */
    public function __construct()
    {

    }

    /**
     * @param $url
     * @param array $data
     * @param array $headers
     * @return RawResponse
     */
    public function get($url, $data = [], $headers = [])
    {
        return $this->request("GET", $url, $data, $headers);
    }

    /**
     * @param $url
     * @param array $data
     * @param array $headers
     * @return RawResponse
     */
    public function post($url, $data = [], $headers = [])
    {
        return $this->request("POST", $url, $data, $headers);
    }

    /**
     * @param $method
     * @param $url
     * @param array $data
     * @param array $headers
     * @return RawResponse
     */
    abstract function request($method, $url, $data = [], $headers = []);
}