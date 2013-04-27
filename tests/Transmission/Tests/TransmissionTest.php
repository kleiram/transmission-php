<?php
namespace Transmission\Tests;

use Transmission\Transmission;

class TransmissionTest extends \PHPUnit_Framework_TestCase
{
    protected $transmission;

    /**
     * @test
     */
    public function shouldHaveDefaultHost()
    {
        $this->assertEquals('localhost', $this->getTransmission()->getClient()->getHost());
    }

    /**
     * @test
     */
    public function shouldGetAllTorrentsInDownloadQueue()
    {
        $client = $this->getMock('Transmission\Client');
        $client->expects($this->once())
            ->method('call')
            ->with('torrent-get')
            ->will($this->returnCallback(function ($method, $arguments) {
                return (object) array(
                    'result' => 'success',
                    'arguments' => (object) array(
                        'torrents' => array(
                            (object) array(),
                            (object) array(),
                            (object) array(),
                        )
                    )
                );
            }));

        $this->getTransmission()->setClient($client);

        $torrents = $this->getTransmission()->all();

        $this->assertCount(3, $torrents);
    }

    /**
     * @test
     */
    public function shouldGetTorrentById()
    {
        $test   = $this;
        $client = $this->getMock('Transmission\Client');
        $client->expects($this->once())
            ->method('call')
            ->with('torrent-get')
            ->will($this->returnCallback(function ($method, $arguments) use ($test) {
                $test->assertEquals(1, $arguments['ids'][0]);

                return (object) array(
                    'result' => 'success',
                    'arguments' => (object) array(
                        'torrents' => array(
                            (object) array()
                        )
                    )
                );
            }));

        $this->getTransmission()->setClient($client);

        $torrent = $this->getTransmission()->get(1);

        $this->assertInstanceOf('Transmission\Model\Torrent', $torrent);
    }

    /**
     * @test
     * @expectedException RuntimeException
     */
    public function shouldThrowExceptionWhenTorrentIsNotFound()
    {
        $client = $this->getMock('Transmission\Client');
        $client->expects($this->once())
            ->method('call')
            ->with('torrent-get')
            ->will($this->returnCallback(function ($method, $arguments) {
                return (object) array(
                    'result' => 'success',
                    'arguments' => (object) array(
                        'torrents' => array()
                    )
                );
            }));

        $this->getTransmission()->setClient($client);
        $this->getTransmission()->get(1);
    }

    /**
     * @test
     */
    public function shouldAddTorrentByFilename()
    {
        $test   = $this;
        $client = $this->getMock('Transmission\Client');
        $client->expects($this->once())
            ->method('call')
            ->with('torrent-add')
            ->will($this->returnCallback(function ($method, $arguments) use ($test) {
                $test->assertArrayHasKey('filename', $arguments);

                return (object) array(
                    'result' => 'success',
                    'arguments' => (object) array(
                        'torrent-added' => (object) array()
                    )
                );
            }));

        $this->getTransmission()->setClient($client);

        $torrent = $this->getTransmission()->add('foo');
        $this->assertInstanceOf('Transmission\Model\Torrent', $torrent);
    }

    /**
     * @test
     */
    public function shouldAddTorrentByMetainfo()
    {
        $test   = $this;
        $client = $this->getMock('Transmission\Client');
        $client->expects($this->once())
            ->method('call')
            ->with('torrent-add')
            ->will($this->returnCallback(function ($method, $arguments) use ($test) {
                $test->assertArrayHasKey('metainfo', $arguments);

                return (object) array(
                    'result' => 'success',
                    'arguments' => (object) array(
                        'torrent-added' => (object) array()
                    )
                );
            }));

        $this->getTransmission()->setClient($client);

        $torrent = $this->getTransmission()->add('foo', true);
        $this->assertInstanceOf('Transmission\Model\Torrent', $torrent);
    }

    /**
     * @test
     */
    public function shouldHaveDefaultPort()
    {
        $this->assertEquals(9091, $this->getTransmission()->getClient()->getPort());
    }

    public function setup()
    {
        $this->transmission = new Transmission();
    }

    private function getTransmission()
    {
        return $this->transmission;
    }
}
