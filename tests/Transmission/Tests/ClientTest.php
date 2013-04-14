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
            ->expects($this->once())
            ->method('post')
            ->with(
                'http://localhost:9091/transmission/rpc',
                array(
                    'User-agent: transmission-rpc/0.4.0',
                    'X-Transmission-Session-Id: foo',
                ),
                '{"method":"foo","arguments":{"bar":"baz"},"tag":"foo"}'
            )
            ->will($this->returnValue($response));

        $client = new Client();
        $client->setToken('foo');
        $client->setBrowser($browser);

        $stdClass = $client->call('foo', array('bar' => 'baz'), 'foo');

        $this->assertInstanceOf('stdClass', $stdClass);
        $this->assertObjectHasAttribute('foo', $stdClass);
        $this->assertEquals('bar', $stdClass->foo);
    }

    /**
     * @test
     */
    public function shouldAuthenticate()
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
            ->expects($this->once())
            ->method('post')
            ->with(
                'http://localhost:9091/transmission/rpc',
                $this->contains('Authorization: Basic '. base64_encode('foo:bar'))
            )
            ->will($this->returnValue($response));

        $client = new Client();
        $client->setToken('foo');
        $client->setBrowser($browser);
        $client->authenticate('foo', 'bar');
        $client->call('foo');
    }

    /**
     * @test
     */
    public function shouldNotAuthenticate()
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
            ->expects($this->once())
            ->method('post')
            ->with(
                'http://localhost:9091/transmission/rpc',
                $this->contains('X-Transmission-Session-Id: foo')
            )
            ->will($this->returnValue($response));

        $client = new Client();
        $client->setToken('foo');
        $client->setBrowser($browser);
        $client->authenticate(null, null);
        $client->call('foo');
    }

    /**
     * @test
     * @expectedException Transmission\Exception\AuthenticationException
     */
    public function shouldThrowExceptionOnAuthenticationError()
    {
        $response = $this->getMock('Buzz\Message\Response');
        $response
            ->expects($this->once())
            ->method('getStatusCode')
            ->will($this->returnValue(401));

        $browser = $this->getMock('Buzz\Browser');
        $browser
            ->expects($this->once())
            ->method('post')
            ->will($this->returnValue($response));

        $client = new Client();
        $client->setBrowser($browser);
        $client->call('foo');
    }

    /**
     * @test
     */
    public function shouldHandle409ResponseWhenMakingApiCalls()
    {
        $validResponse = $this->getMock('Buzz\Message\Response');
        $validResponse
            ->expects($this->once())
            ->method('getStatusCode')
            ->will($this->returnValue(200));

        $validResponse
            ->expects($this->once())
            ->method('getContent')
            ->will($this->returnValue('{"foo":"bar"}'));

        $invalidResponse = $this->getMock('Buzz\Message\Response');
        $invalidResponse
            ->expects($this->once())
            ->method('getStatusCode')
            ->will($this->returnValue(409));

        $invalidResponse
            ->expects($this->exactly(2))
            ->method('getHeader')
            ->with('X-Transmission-Session-Id')
            ->will($this->returnValue('foo'));

        $browser = $this->getMock('Buzz\Browser');
        $browser
            ->expects($this->at(0))
            ->method('post')
            ->will($this->returnValue($invalidResponse));

        $browser
            ->expects($this->at(1))
            ->method('post')
            ->will($this->returnValue($validResponse));

        $client = new Client();
        $client->setBrowser($browser);

        $stdClass = $client->call('foo');

        $this->assertEquals('foo', $client->getToken());
        $this->assertInstanceOf('stdClass', $stdClass);
        $this->assertObjectHasAttribute('foo', $stdClass);
        $this->assertEquals('bar', $stdClass->foo);
    }

    /**
     * @test
     * @expectedException Transmission\Exception\ConnectionException
     */
    public function shouldHandleConnectionExceptionsWhenMakingApiCalls()
    {
        $browser = $this->getMock('Buzz\Browser');
        $browser
            ->expects($this->once())
            ->method('post')
            ->will($this->throwException(new \RuntimeException()));

        $client = new Client();
        $client->setBrowser($browser);
        $client->call('foo');
    }

    /**
     * @test
     * @expectedException Transmission\Exception\InvalidResponseException
     */
    public function shouldThrowExceptionWithUnsetHeaderOn409Response()
    {
        $response = $this->getMock('Buzz\Message\Response');
        $response
            ->expects($this->once())
            ->method('getStatusCode')
            ->will($this->returnValue(409));

        $browser = $this->getMock('Buzz\Browser');
        $browser
            ->expects($this->once())
            ->method('post')
            ->will($this->returnValue($response));

        $client = new Client();
        $client->setBrowser($browser);
        $client->call('foo');
    }

    /**
     * @test
     * @expectedException Transmission\Exception\UnexpectedResponseException
     */
    public function shouldThrowExceptionOnInvalidStatusCode()
    {
        $response = $this->getMock('Buzz\Message\Response');
        $response
            ->expects($this->once())
            ->method('getStatusCode')
            ->will($this->returnValue(302));

        $browser = $this->getMock('Buzz\Browser');
        $browser
            ->expects($this->once())
            ->method('post')
            ->will($this->returnValue($response));

        $client = new Client();
        $client->setBrowser($browser);
        $client->call('foo');
    }

    /**
     * @test
     * @expectedException Transmission\Exception\InvalidResponseException
     */
    public function shouldThrowExceptionOnInvalidContent()
    {
        $response = $this->getMock('Buzz\Message\Response');
        $response
            ->expects($this->once())
            ->method('getStatusCode')
            ->will($this->returnValue(200));

        $response
            ->expects($this->once())
            ->method('getContent')
            ->will($this->returnValue('Invalid JSON'));

        $browser = $this->getMock('Buzz\Browser');
        $browser
            ->expects($this->once())
            ->method('post')
            ->will($this->returnValue($response));

        $client = new Client();
        $client->setBrowser($browser);
        $client->call('foo');
    }
}
