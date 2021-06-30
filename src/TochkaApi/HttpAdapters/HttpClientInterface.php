<?php

namespace TochkaApi\HttpAdapters;


use TochkaApi\Auth\AccessToken;
use TochkaApi\Responses\RawResponse;

/**
 * Interface HttpClientInterface
 * @package TochkaApi\HttpAdapters
 */
interface HttpClientInterface
{
    /**
     * @param $url
     * @param array $data
     * param array $headers
     * @return RawResponse
     */
    public function get($url, $data = [], $headers = []);

    /**
     * @param $url
     * @param array $data
     * param array $headers
     * @return RawResponse
     */
    public function post($url, $data = [], $headers = []);


    /**
     * @param $method
     * @param $url
     * @param array $data
     * @param array $headers
     * @return RawResponse
     */
    public function request($method, $url, $data = [], $headers = []);
}