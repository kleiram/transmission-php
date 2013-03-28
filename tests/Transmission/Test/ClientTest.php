<?php
namespace Transmission\Test;

use Transmission\Client;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    public function testDefaultHostAndPort()
    {
        $client = new Client();
        $this->assertEquals('localhost', $client->getHost());
        $this->assertEquals(9091, $client->getPort());
    }

    public function testCustomHostAndPort()
    {
        $client = new Client('example.org', 8080);
        $this->assertEquals('example.org', $client->getHost());
        $this->assertEquals(8080, $client->getPort());
    }

    public function testMakeApiCallWithTokenAndValidResponse()
    {
        $client = new Client();

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
                'http://localhost:9091/transmission/rpc/',
                array(
                    'X-Transmission-Session-Id: foo'
                ),
                '{"bar":"baz"}'
            )
            ->will($this->returnValue($response));

        $client->setBrowser($browser);
        $client->setToken('foo');

        $object = $client->call('{"bar":"baz"}');

        $this->assertInstanceOf('stdClass', $object);
        $this->assertEquals('bar', $object->foo);
    }

    public function testMakeApiCallWithTokenAndInvalidResponse()
    {
        $this->setExpectedException('Transmission\Exception\InvalidResponseException');

        $client = new Client();

        $response = $this->getMock('Buzz\Message\Response');
        $response
            ->expects($this->once())
            ->method('getStatusCode')
            ->will($this->returnValue(200));

        $response
            ->expects($this->once())
            ->method('getContent')
            ->will($this->returnValue('Invalid json response, whoooo!'));

        $browser = $this->getMock('Buzz\Browser');
        $browser
            ->expects($this->once())
            ->method('post')
            ->with(
                'http://localhost:9091/transmission/rpc/',
                array(
                    'X-Transmission-Session-Id: foo'
                ),
                '{"bar":"baz"}'
            )
            ->will($this->returnValue($response));

        $client->setBrowser($browser);
        $client->setToken('foo');
        $client->call('{"bar":"baz"}');
    }

    public function testMakeApiCallWithInvalidToken()
    {
        $this->setExpectedException('Transmission\Exception\InvalidTokenException');

        $client = new Client();

        $response = $this->getMock('Buzz\Message\Response');
        $response
            ->expects($this->once())
            ->method('getStatusCode')
            ->will($this->returnValue(409));

        $browser = $this->getMock('Buzz\Browser');
        $browser
            ->expects($this->once())
            ->method('post')
            ->with(
                'http://localhost:9091/transmission/rpc/',
                array(
                    'X-Transmission-Session-Id: foo'
                ),
                '{"bar":"baz"}'
            )
            ->will($this->returnValue($response));

        $client->setBrowser($browser);
        $client->setToken('foo');
        $client->call('{"bar":"baz"}');
    }

    public function testExceptionInApiCall()
    {
        $this->setExpectedException('Transmission\Exception\ConnectionException');

        $client = new Client();

        $browser = $this->getMock('Buzz\Browser');
        $browser
            ->expects($this->once())
            ->method('post')
            ->with(
                'http://localhost:9091/transmission/rpc/',
                array(
                    'X-Transmission-Session-Id: foo'
                ),
                '{"bar":"baz"}'
            )
            ->will($this->throwException(new \Exception()));

        $client->setBrowser($browser);
        $client->setToken('foo');
        $client->call('{"bar":"baz"}');
    }

    public function testGetSessionToken()
    {
        $client  = new Client();
        $browser = $this->getMock('Buzz\Browser');

        $response = $this->getMock('Buzz\Message\Response');
        $response
            ->expects($this->once())
            ->method('getStatusCode')
            ->will($this->returnValue(409));

        $response
            ->expects($this->once())
            ->method('getHeader')
            ->with('X-Transmission-Session-Id')
            ->will($this->returnValue('foo'));

        $browser
            ->expects($this->once())
            ->method('post')
            ->with('http://localhost:9091/transmission/rpc')
            ->will($this->returnValue($response));

        $client->setBrowser($browser);
        $client->generateToken();

        $this->assertEquals('foo', $client->getToken());
    }

    public function testExceptionInGenerateSessionToken()
    {
        $this->setExpectedException('Transmission\Exception\ConnectionException');

        $browser = $this->getMock('Buzz\Browser');
        $browser
            ->expects($this->once())
            ->method('post')
            ->with('http://localhost:9091/transmission/rpc')
            ->will($this->throwException(new \Exception()));

        $client = new Client();
        $client->setBrowser($browser);
        $client->generateToken();
    }

    public function testUnexpectedResponseInGenerateSessionToken()
    {
        $this->setExpectedException('Transmission\Exception\UnexpectedResponseException');

        $response = $this->getMock('Buzz\Message\Response');
        $response
            ->expects($this->exactly(2))
            ->method('getStatusCode')
            ->will($this->returnValue(200));

        $browser = $this->getMock('Buzz\Browser');
        $browser
            ->expects($this->once())
            ->method('post')
            ->with('http://localhost:9091/transmission/rpc')
            ->will($this->returnValue($response));

        $client = new Client();
        $client->setBrowser($browser);
        $client->generateToken();
    }

    public function testGenerateUrlFromPathWithoutLeadingSlash()
    {
        $client = new Client();

        $this->assertEquals(
            'http://localhost:9091/transmission/rpc/foo',
            $client->getUrl('foo')
        );
    }

    public function testGenerateUrlFromPathWithLeadingSlash()
    {
        $client = new Client();

        $this->assertEquals(
            'http://localhost:9091/transmission/rpc/foo',
            $client->getUrl('/foo')
        );
    }

    public function testGenerateUrlWithParameters()
    {
        $client = new Client();

        $this->assertEquals(
            'http://localhost:9091/transmission/rpc/foo?bar=baz',
            $client->getUrl('foo', array('bar' => 'baz'))
        );
    }

    public function testGenerateUrlFromUrl()
    {
        $client = new Client();

        $this->assertEquals(
            'http://example.org:8080/foo',
            $client->getUrl('http://example.org:8080/foo')
        );
    }
}
