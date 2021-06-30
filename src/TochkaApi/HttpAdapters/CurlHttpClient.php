<?php

namespace TochkaApi\HttpAdapters;

use TochkaApi\Responses\RawResponse;

/**
 * Class CurlHttpClient
 * @package TochkaApi\HttpAdapters
 */
class CurlHttpClient extends HttpAdapterBase implements HttpClientInterface
{
    /**
     * @var
     */
    protected $client;

    /**
     * @var array $cookies
     */
    protected $cookies = [];

    /**
     * @param $method
     * @param $url
     * @param array $data
     * @param array $headers
     * @return RawResponse
     * @throws \TochkaApi\Exceptions\AuthorizationApiException
     * @throws \TochkaApi\Exceptions\PermissionApiException
     * @throws \TochkaApi\Exceptions\RequestException
     */
    public function request($method, $url, $data = [], $headers = [])
    {
        $this->client = curl_init();

        curl_setopt($this->client, CURLOPT_URL, $url);

        if(!empty($headers)) {
            curl_setopt($this->client, CURLOPT_HTTPHEADER, $this->compileRequestHeaders($headers));
        }

        curl_setopt($this->client, CURLOPT_VERBOSE, false);

        curl_setopt($this->client, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($this->client, CURLOPT_CUSTOMREQUEST, $method);

        curl_setopt($this->client, CURLOPT_SSL_VERIFYHOST, FALSE);

        curl_setopt($this->client, CURLOPT_SSL_VERIFYPEER, FALSE);

        curl_setopt( $this->client, CURLOPT_HEADER, TRUE);

        if(!empty($data)) {
            curl_setopt($this->client, CURLOPT_POST, TRUE);
            curl_setopt($this->client,CURLOPT_POSTFIELDS, $data);

            if(is_array($data)) {
                curl_setopt($this->client, CURLOPT_URL, ($url . "?" . http_build_query($data)));
            }
        }

        $returnData = curl_exec($this->client);

        $headerSize = curl_getinfo($this->client, CURLINFO_HEADER_SIZE);
        $header = substr($returnData, 0, $headerSize);

        $body = substr($returnData, $headerSize);

        $this->getCookies($header);

        $response = new RawResponse([], $body, curl_getinfo($this->client, CURLINFO_HTTP_CODE));

        if (!in_array($response->getCode(), [200, 302])) {
            $response->handleError();
        }

        curl_close($this->client);

        return $response;
    }

    /**
     * @param $header
     */
    private function getCookies($header)
    {
        if(preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $header, $matches)) {
            foreach($matches[1] as $item) {
                parse_str($item, $cookie);

                $this->cookies = array_merge($this->cookies, $cookie);
            }
        }
    }

    /**
     * @param array $headers
     * @return array
     */
    private function compileRequestHeaders(array $headers)
    {
        $return = [];

        foreach ($headers as $key => $value) {
            $return[] = $key . ': ' . $value;
        }

        return $return;
    }
}