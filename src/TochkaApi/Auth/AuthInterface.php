<?php

namespace TochkaApi\Auth;


/**
 * Interface AuthInterface
 * @package TochkaApi\Auth
 */
interface AuthInterface
{
    /**
     * @return array
     */
    public function getHeaders();
}