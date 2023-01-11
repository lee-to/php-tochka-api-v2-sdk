<?php

namespace TochkaApi\Tests;

use PHPUnit\Framework\TestCase;
use TochkaApi\Auth\AccessToken;
use TochkaApi\Auth\BearerAuth;
use TochkaApi\Client;
use TochkaApi\HttpAdapters\CurlHttpClient;

class ClientTest extends TestCase
{
    public function testExclude()
    {
        $this->assertTrue(true);
    }

    public function testClient()
    {
        $client = new Client("test", "test","https://example.com", new CurlHttpClient);

        $this->assertEquals("https://example.com", $client->getRedirectUri());
        $this->assertNotEmpty($client->getScopes());

        $client->setScopes("test");
        $this->assertEquals("test", $client->getScopes());


        $this->assertEquals("", $client->getAccessToken());

        $response = $client->getAdapter()->request("GET", "https://ya.ru");

        $this->assertEquals(200, $response->getCode());

        $this->expectExceptionMessage("The access token is missing");
        $client->statement()->all();

        $this->expectExceptionMessage("Access token error");
        $client->authorize();
        $client->token("test");
    }

    public function testAccessTokenClass()
    {
        $token = new AccessToken("test", 7200, "test");

        $this->assertEquals("test", $token->getAccessToken());
        $this->assertEquals("test", $token->getRefreshToken());
        $this->assertFalse($token->isExpired(time()));
    }

    public function testBearerAuthClass()
    {
        $token = new AccessToken("test", 7200, "test");
        $bearerAuth = new BearerAuth($token);

        $this->assertEquals($bearerAuth->getToken(), $token->getAccessToken());
        $this->assertEquals($bearerAuth->getToken(), "test");

        $this->assertArrayHasKey("Authorization", $bearerAuth->getHeaders());
    }
}
