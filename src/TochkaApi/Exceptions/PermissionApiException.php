<?php

namespace TochkaApi\Exceptions;


class PermissionApiException extends BaseApiException
{
    const HTTP_CODE = 501;

    /**
     * PermissionException constructor.
     * @param array $responseHeaders
     * @param null $responseBody
     */
    public function __construct($responseHeaders = [], $responseBody = null)
    {
        $this->parseResponseBody($responseBody);

        parent::__construct($this->message, self::HTTP_CODE, $responseHeaders, $responseBody);
    }
}