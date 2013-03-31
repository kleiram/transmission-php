<?php
namespace Transmission\Tests;

use Mockery as Mock;
use Transmission\Client;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldHaveDefaultConnectionValues()
    {
        $client = new Client();

        $this->assertEquals('localhost', $client->getHost());
        $this->assertEquals(9091, $client->getPort());
        $this->assertEquals(null, $client->getToken());
        $this->assertInstanceOf('Buzz\Browser', $client->getBrowser());
    }

    /**
     * @test
     */
    public function shouldHandleCustomConnectionValues()
    {
        $client = new Client('example.org', 80);

        $this->assertEquals('example.org', $client->getHost());
        $this->assertEquals(80, $client->getPort());
    }

    /**
     * @test
     */
    public function shouldMakeApiCalls()
    {
        $browser = $this->getMock('Buzz\Browser');
        $browser
            ->expects($this->at(0))
            ->method('post')
            ->with(
                'http://localhost:9091/transmission/rpc',
                $this->contains('X-Transmission-Session-Id: some-secret-token'),
                '{"method":"foo","arguments":{"foo:"bar"}}'
            )
            ->will($this->returnValue($this->getApiResponse()));

        $client = new Client();
        $client->setToken('some-secret-token');
        $client->setBrowser($browser);

        $object = $client->call('foo', array('foo' => 'bar'));

        $this->assertInstanceOf('stdClass', $object);
        $this->assertObjectHasAttribute('foo', $object);
        $this->assertEquals('bar', $object->foo);
    }

    /**
     * @test
     */
    public function shouldRequestTokenWhenMakingApiCallsWithoutToken()
    {
        $browser = $this->getMock('Buzz\Browser');
        $browser
            ->expects($this->exactly(2))
            ->method('post');

        $browser
            ->expects($this->at(0))
            ->method('post')
            ->with(
                'http://localhost:9091/transmission/rpc',
                array()
            )
            ->will($this->returnValue($this->getTokenRequestResponse()));

        $browser
            ->expects($this->at(1))
            ->method('post')
            ->with(
                'http://localhost:9091/transmission/rpc',
                $this->contains('X-Transmission-Session-Id: some-secret-token'),
                '{"method":"foo","arguments":{"foo":"bar"}}'
            )
            ->will($this->returnValue($this->getApiResponse()));

        $client = new Client();
        $client->setBrowser($browser);

        $object = $client->call('foo', array('foo' => 'bar'));

        $this->assertInstanceOf('stdClass', $object);
        $this->assertObjectHasAttribute('foo', $object);
        $this->assertEquals('bar', $object->foo);
        $this->assertEquals('some-secret-token', $client->getToken());
    }

    private function getApiResponse()
    {
        $response = $this->getMock('Buzz\Message\Response');
        $response
            ->expects($this->once())
            ->method('getStatusCode')
            ->will($this->returnValue(200));

        $response
            ->expects($this->once())
            ->method('getContent')
            ->will($this->returnValue('{"foo":"bar"}'));

        return $response;
    }

    private function getTokenRequestResponse()
    {
        $response = $this->getMock('Buzz\Message\Response');
        $response
            ->expects($this->once())
            ->method('getStatusCode')
            ->will($this->returnValue(409));

        $response
            ->expects($this->once())
            ->method('getHeader')
            ->with('X-Transmission-Session-Id')
            ->will($this->returnValue('some-secret-token'));

        return $response;
    }
}
