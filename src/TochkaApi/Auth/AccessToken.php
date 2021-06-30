<?php

namespace TochkaApi\Auth;


/**
 * Class AccessToken
 * @package TochkaApi\Auth
 */
class AccessToken
{
    /**
     * @var string $access_token
     */
    protected $access_token;

    /**
     * @var string $refresh_token
     */
    protected $refresh_token;

    /**
     * @var integer $expires_in
     */
    protected $expires_in;

    /**
     * AccessToken constructor.
     * @param string $access_token
     * @param int $expires_in
     * @param string $refresh_token
     */
    public function __construct($access_token, $expires_in = 7200, $refresh_token = "")
    {
        $this->setAccessToken($access_token);
        $this->setExpiresIn($expires_in);
        $this->setRefreshToken($refresh_token);
    }

    /**
     * @return string
     */
    public function getRefreshToken()
    {
        return $this->refresh_token;
    }

    /**
     * @param string $refresh_token
     */
    public function setRefreshToken($refresh_token)
    {
        $this->refresh_token = $refresh_token;
    }


    /**
     * @return string
     */
    public function getAccessToken()
    {
        return $this->access_token;
    }

    /**
     * @param string $access_token
     */
    public function setAccessToken($access_token)
    {
        $this->access_token = $access_token;
    }

    /**
     * @return int
     */
    public function getExpiresIn()
    {
        return $this->expires_in;
    }


    /**
     * @param int $expires_in
     */
    public function setExpiresIn($expires_in)
    {
        $this->expires_in = $expires_in;
    }

    /**
     * @param integer $createdAt
     * @return bool|null
     */
    public function isExpired($createdAt)
    {
        return !(($createdAt + $this->getExpiresIn()) > time());
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getAccessToken();
    }
}