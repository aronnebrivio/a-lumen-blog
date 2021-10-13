<?php

/**
 * @internal
 */
class CorsMiddlewareTest extends TestCase
{
    public function testGetRequest()
    {
        $response = $this->call('GET', 'version');

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('POST, GET, OPTIONS, PUT, DELETE', $response->headers->get('Access-Control-Allow-Methods'));
        $this->assertEquals('*', $response->headers->get('Access-Control-Allow-Origin'));
        $this->assertEquals('true', $response->headers->get('Access-Control-Allow-Credentials'));
        $this->assertEquals('Origin, Content-Type, Accept, Authorization, X-Request-With', $response->headers->get('Access-Control-Allow-Headers'));
    }

    public function testPostRequest()
    {
        $response = $this->call('POST', 'version');

        $this->assertEquals(405, $response->getStatusCode());
        $this->assertEquals('POST, GET, OPTIONS, PUT, DELETE', $response->headers->get('Access-Control-Allow-Methods'));
        $this->assertEquals('*', $response->headers->get('Access-Control-Allow-Origin'));
        $this->assertEquals('true', $response->headers->get('Access-Control-Allow-Credentials'));
        $this->assertEquals('Origin, Content-Type, Accept, Authorization, X-Request-With', $response->headers->get('Access-Control-Allow-Headers'));
    }

    public function testOptionRequest()
    {
        $response = $this->call('OPTIONS', 'version');

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('POST, GET, OPTIONS, PUT, DELETE', $response->headers->get('Access-Control-Allow-Methods'));
        $this->assertEquals('*', $response->headers->get('Access-Control-Allow-Origin'));
        $this->assertEquals('true', $response->headers->get('Access-Control-Allow-Credentials'));
        $this->assertEquals('Origin, Content-Type, Accept, Authorization, X-Request-With', $response->headers->get('Access-Control-Allow-Headers'));
    }
}
