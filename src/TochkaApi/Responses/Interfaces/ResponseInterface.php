<?php

namespace TochkaApi\Responses\Interfaces;


/**
 * Interface ResponseInterface
 * @package TochkaApi\Responses\Interfaces
 */
interface ResponseInterface
{
    /**
     * @return mixed
     */
    public function getBody();

    /**
     * @return mixed
     */
    public function getCode();

    /**
     * @return mixed
     */
    public function getHeaders();

    /**
     * @return array
     */
    public function getArray();
}