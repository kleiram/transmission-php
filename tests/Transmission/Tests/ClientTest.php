<?php
namespace Transmission\Tests;

use Transmission\Client;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldHaveDefaultConnectionDetails()
    {
        $client = new Client();

        $this->assertEquals('localhost', $client->getHost());
        $this->assertEquals(9091, $client->getPort());
        $this->assertNull($client->getToken());
        $this->assertInstanceOf('Buzz\Browser', $client->getBrowser());
    }

    /**
     * @test
     */
    public function shouldHandleCustomConnectionDetails()
    {
        $client = new Client('example.com', 80);

        $this->assertEquals('example.com', $client->getHost());
        $this->assertEquals(80, $client->getPort());
    }
}
