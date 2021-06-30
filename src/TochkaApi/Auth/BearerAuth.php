<?php

namespace TochkaApi\Auth;


/**
 * Class BearerAuth
 * @package TochkaApi\Auth
 */
class BearerAuth implements AuthInterface
{
    /**
     * @var
     */
    private $token;

    /**
     * BearerAuth constructor.
     * @param AccessToken $token
     */
    public function __construct(AccessToken $token)
    {
        $this->setToken($token);
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param AccessToken $token
     */
    private function setToken(AccessToken $token)
    {
        $this->token = $token->getAccessToken();
    }


    /**
     * @return array
     */
    public function getHeaders()
    {
        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];

        if($this->getToken() != "") {
            $headers['Authorization'] = "Bearer {$this->getToken()}";
        }

        return $headers;
    }
}