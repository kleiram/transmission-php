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
        $response = $this->getMock('Buzz\Message\Response');
        $response
            ->expects($this->once())
            ->method('getStatusCode')
            ->will($this->returnValue(200));

        $response
            ->expects($this->once())
            ->method('getContent')
            ->will($this->returnValue('{"foo":"bar"}'));

        $browser = $this->getMock('Buzz\Browser');
        $browser
            ->expects($this->at(0))
            ->method('post')
            ->with(
                'http://localhost:9091/transmission/rpc',
                $this->contains('X-Transmission-Session-Id: some-secret-token'),
                '{"method":"foo","arguments":{"foo":"bar"}}'
            )
            ->will($this->returnValue($response));

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
        $tokenResponse = $this->getMock('Buzz\Message\Response');
        $tokenResponse
            ->expects($this->once())
            ->method('getStatusCode')
            ->will($this->returnValue(409));

        $tokenResponse
            ->expects($this->once())
            ->method('getHeader')
            ->with('X-Transmission-Session-Id')
            ->will($this->returnValue('some-secret-token'));

        $response = $this->getMock('Buzz\Message\Response');
        $response
            ->expects($this->once())
            ->method('getStatusCode')
            ->will($this->returnValue(200));

        $response
            ->expects($this->once())
            ->method('getContent')
            ->will($this->returnValue('{"foo":"bar"}'));

        $browser = $this->getMock('Buzz\Browser');
        $browser
            ->expects($this->exactly(2))
            ->method('post')
            ->will($this->onConsecutiveCalls(
                $this->returnValue($tokenResponse),
                $this->returnValue($response)
            ));

        $client = new Client();
        $client->setBrowser($browser);

        $object = $client->call('foo', array('foo' => 'bar'));

        $this->assertInstanceOf('stdClass', $object);
        $this->assertObjectHasAttribute('foo', $object);
        $this->assertEquals('bar', $object->foo);
        $this->assertEquals('some-secret-token', $client->getToken());
    }

    /**
     * @test
     * @expectedException Transmission\Exception\ConnectionException
     */
    public function shouldHandleExceptionWhenMakingApiCalls()
    {
        $browser = $this->getMock('Buzz\Browser');
        $browser
            ->expects($this->once())
            ->method('post')
            ->will($this->throwException(new \Exception()));

        $client = new Client();
        $client->setToken('foo');
        $client->setBrowser($browser);
        $client->call('foo', array('bar' => 'baz'));
    }

    /**
     * @test
     * @expectedException Transmission\Exception\UnexpectedResponseException
     */
    public function shouldThrowExceptionWhenNon200StatusCodeIsReceived()
    {
        $response = $this->getMock('Buzz\Message\Response');
        $response
            ->expects($this->exactly(2))
            ->method('getStatusCode')
            ->will($this->returnValue(201));

        $browser = $this->getMock('Buzz\Browser');
        $browser
            ->expects($this->once())
            ->method('post')
            ->will($this->returnValue($response));

        $client = new Client();
        $client->setToken('foo');
        $client->setBrowser($browser);
        $client->call('foo', array('bar' => 'baz'));
    }

    /**
     * @test
     * @expectedException Transmission\Exception\InvalidResponseException
     */
    public function shouldThrowExceptionWhenInvalidContentIsReceived()
    {
        $response = $this->getMock('Buzz\Message\Response');
        $response
            ->expects($this->once())
            ->method('getStatusCode')
            ->will($this->returnValue(200));

        $response
            ->expects($this->once())
            ->method('getContent')
            ->will($this->returnValue('non-json content'));

        $browser = $this->getMock('Buzz\Browser');
        $browser
            ->expects($this->once())
            ->method('post')
            ->will($this->returnValue($response));

        $client = new Client();
        $client->setToken('foo');
        $client->setBrowser($browser);
        $client->call('foo', array('bar' => 'baz'));
    }

    /**
     * @test
     * @expectedException Transmission\Exception\ConnectionException
     */
    public function shouldHandleExceptionWhenRequestingApiToken()
    {
        $browser = $this->getMock('Buzz\Browser');
        $browser
            ->expects($this->once())
            ->method('post')
            ->will($this->throwException(new \Exception()));

        $client = new Client();
        $client->setBrowser($browser);
        $client->requestToken();
    }

    /**
     * @test
     * @expectedException Transmission\Exception\UnexpectedResponseException
     */
    public function shouldThrowExceptionWhenNon409StatusCodeIsReceived()
    {
        $response = $this->getMock('Buzz\Message\Response');
        $response
            ->expects($this->exactly(2))
            ->method('getStatusCode')
            ->will($this->returnValue(200));

        $browser = $this->getMock('Buzz\Browser');
        $browser
            ->expects($this->once())
            ->method('post')
            ->will($this->returnValue($response));

        $client = new Client();
        $client->setBrowser($browser);
        $client->requestToken();
    }

    /**
     * @test
     * @expectedException Transmission\Exception\InvalidResponseException
     */
    public function shouldThrowExceptionWhenNoTokenHeaderIsFound()
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
            ->will($this->returnValue(null));

        $browser = $this->getMock('Buzz\Browser');
        $browser
            ->expects($this->once())
            ->method('post')
            ->will($this->returnValue($response));

        $client = new Client();
        $client->setBrowser($browser);
        $client->requestToken();
    }
}
