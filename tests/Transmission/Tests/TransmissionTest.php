<?php
namespace Transmission\Tests;

use Transmission\Transmission;
use Transmission\Model\Torrent;

class TransmissionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldHaveDefaultObjects()
    {
        $transmission = new Transmission();

        $this->assertInstanceOf('Transmission\Transformer\ModelTransformer', $transmission->getTransformer());
        $this->assertInstanceOf('Transmission\Client', $transmission->getClient());
    }

    /**
     * @test
     */
    public function shouldSetClientHostAndPort()
    {
        $client = $this->getMock('Transmission\Client');
        $client
            ->expects($this->once())
            ->method('setHost');

        $client
            ->expects($this->once())
            ->method('getHost');

        $client
            ->expects($this->once())
            ->method('setPort');

        $client
            ->expects($this->once())
            ->method('getPort');

        $transmission = new Transmission();
        $transmission->setClient($client);
        $transmission->setHost('example.org');
        $transmission->getHost();
        $transmission->setPort(80);
        $transmission->getPort();
    }

    /**
     * @test
     */
    public function shouldGetAllTorrents()
    {
        $response = (object) array(
            'arguments' => (object) array(
                'torrents' => array(
                    (object) array(
                        'id' => 1,
                        'name' => 'foo'
                    )
                )
            ),
            'status' => 'success'
        );

        $client = $this->getMock('Transmission\Client');
        $client
            ->expects($this->once())
            ->method('call')
            ->with(
                'torrent-get',
                array(
                    'fields' => array_values(Torrent::getMapping())
                )
            )
            ->will($this->returnValue($response));

        $transmission = new Transmission();
        $transmission->setClient($client);

        $torrents = $transmission->getTorrents();

        $this->assertCount(1, $torrents);
        $this->assertInstanceOf('Transmission\Model\Torrent', $torrents[0]);
        $this->assertEquals(1, $torrents[0]->getId());
        $this->assertEquals('foo', $torrents[0]->getName());
    }

    /**
     * @test
     */
    public function shouldGetASpecificTorrent()
    {
        $response = (object) array(
            'arguments' => (object) array(
                'torrents' => array(
                    (object) array(
                        'id' => 1,
                        'name' => 'foo'
                    )
                )
            ),
            'status' => 'success'
        );

        $client = $this->getMock('Transmission\Client');
        $client
            ->expects($this->once())
            ->method('call')
            ->with(
                'torrent-get',
                array(
                    'fields' => array_values(Torrent::getMapping()),
                    'ids' => array(1)
                )
            )
            ->will($this->returnValue($response));

        $transmission = new Transmission();
        $transmission->setClient($client);

        $torrent = $transmission->getTorrent(1);

        $this->assertInstanceOf('Transmission\Model\Torrent', $torrent);
        $this->assertEquals(1, $torrent->getId());
        $this->assertEquals('foo', $torrent->getName());
    }

    /**
     * @test
     * @expectedException Transmission\Exception\TorrentNotFoundException
     */
    public function shouldThrowExceptionWhenTorrentIsNotFound()
    {
        $response = (object) array(
            'arguments' => (object) array(
                'torrents' => array()
            ),
            'status' => 'success'
        );

        $client = $this->getMock('Transmission\Client');
        $client
            ->expects($this->once())
            ->method('call')
            ->with(
                'torrent-get',
                array(
                    'fields' => array_values(Torrent::getMapping()),
                    'ids' => array(1)
                )
            )
            ->will($this->returnValue($response));

        $transmission = new Transmission();
        $transmission->setClient($client);
        $transmission->getTorrent(1);
    }

    /**
     * @test
     */
    public function shouldAddTorrent()
    {
        $response = (object) array(
            'arguments' => (object) array(
                'torrent-added' => (object) array(
                    'id' => 1,
                    'name' => 'foo',
                    'hashString' => sha1('foo')
                )
            ),
            'status' => 'success'
        );

        $client = $this->getMock('Transmission\Client');
        $client
            ->expects($this->once())
            ->method('call')
            ->with(
                'torrent-add',
                array(
                    'filename' => 'foo'
                )
            )
            ->will($this->returnValue($response));

        $transmission = new Transmission();
        $transmission->setClient($client);

        $torrent = $transmission->addTorrent('foo');

        $this->assertInstanceOf('Transmission\Model\Torrent', $torrent);
        $this->assertEquals(1, $torrent->getId());
        $this->assertEquals('foo', $torrent->getName());
    }

    /**
     * @test
     * @expectedException Transmission\Exception\InvalidResponseException
     */
    public function shouldThrowExceptionWhenNoArgumentsAreFound()
    {
        $response = (object) array(
            'status' => 'success'
        );

        $transmission = new Transmission();
        $transmission->checkResponse($response);
    }

    /**
     * @test
     * @expectedException Transmission\Exception\InvalidResponseException
     */
    public function shouldThrowExceptionWhenNoStatusIsFound()
    {
        $response = (object) array(
            'arguments' => (object) array()
        );

        $transmission = new Transmission();
        $transmission->checkResponse($response);
    }

    /**
     * @test
     * @expectedException Transmission\Exception\ErrorException
     */
    public function shouldThrowExceptionWhenStatusIsNotSucces()
    {
        $response = (object) array(
            'arguments' => (object) array(),
            'status' => 'unsuccesfull status'
        );

        $transmission = new Transmission();
        $transmission->checkResponse($response);
    }
}
