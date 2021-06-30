<?php

namespace TochkaApi\Exceptions;

use Exception;

/**
 * Class BaseApiException
 * @package TochkaApi\Exceptions
 */
class BaseApiException extends Exception
{
    /**
     * @var mixed
     */
    protected $responseBody;

    /**
     * @var string[]
     */
    protected $responseHeaders;


    /**
     * @var string
     */
    public $message = "";

    /**
     * Constructor
     *
     * @param string $message Error message
     * @param int $code HTTP status code
     * @param string[] $responseHeaders HTTP header
     * @param mixed $responseBody HTTP body
     */
    public function __construct($message = "", $code = 0, $responseHeaders = [], $responseBody = null)
    {
        parent::__construct($message, $code);

        $this->responseHeaders = $responseHeaders;
        $this->responseBody = $responseBody;
    }

    /**
     * @param $responseBody
     */
    public function parseResponseBody($responseBody)
    {
        if($this->isJson($responseBody)) {
            $data = json_decode($responseBody, true);

            $responseBody = $data["message"];
        }

        $this->message = $responseBody;
    }

    /**
     * @return string[]
     */
    public function getResponseHeaders()
    {
        return $this->responseHeaders;
    }

    /**
     * @return mixed
     */
    public function getResponseBody()
    {
        return $this->responseBody;
    }

    /**
     * @param $string
     * @return bool
     */
    private function isJson($string)
    {
        json_decode($string);

        return json_last_error() === JSON_ERROR_NONE;
    }
}