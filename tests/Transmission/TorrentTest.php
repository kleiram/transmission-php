<?php
namespace Transmission\Tests;

use Transmission\Torrent;

class TorrentTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldProcessASuccesfullGetTorrentRequest()
    {
        $response = (object) array(
            'result' => 'success',
            'arguments' => (object) array(
                'torrents' => array(
                    (object) array(
                        'id' => 1,
                        'name' => 'Example'
                    )
                )
            )
        );

        $client = $this->getMock('Transmission\Client');
        $client
            ->expects($this->once())
            ->method('call')
            ->with('torrent-get')
            ->will($this->returnValue($response));

        $torrent = Torrent::get(1, $client);

        $this->assertInstanceOf(
            'Transmission\Torrent',
            $torrent
        );
        $this->assertEquals(
            $client,
            $torrent->getClient()
        );
        $this->assertEquals(
            1,
            $torrent->getId()
        );
        $this->assertEquals(
            'Example',
            $torrent->getName()
        );
    }

    /**
     * @test
     * @expectedException RuntimeException
     */
    public function shouldThrowExceptionOnUnsuccesfullResultMessage()
    {
        $response = (object) array(
            'result' => 'Some error message'
        );

        $client = $this->getMock('Transmission\Client');
        $client
            ->expects($this->once())
            ->method('call')
            ->will($this->returnValue($response));

        Torrent::get(1, $client);
    }

    /**
     * @test
     * @expectedException Transmission\Exception\InvalidResponseException
     * @dataProvider invalidResponseProvider
     */
    public function shouldThrowExceptionOnMissingFieldsInGetTorrentRequest($response)
    {
        $client = $this->getMock('Transmission\Client');
        $client
            ->expects($this->once())
            ->method('call')
            ->will($this->returnValue($response));

        Torrent::get(1, $client);
    }

    /**
     * @test
     * @expectedException Transmission\Exception\NoSuchTorrentException
     */
    public function shouldThrowExceptionWhenTorrentIsNotFoundInGetTorrentRequest()
    {
        $response = (object) array(
            'result' => 'success',
            'arguments' => (object) array(
                'torrents' => array()
            )
        );

        $client = $this->getMock('Transmission\Client');
        $client
            ->expects($this->once())
            ->method('call')
            ->will($this->returnValue($response));

        Torrent::get(1, $client);
    }

    public function invalidResponseProvider()
    {
        $responses = array();

        $responses[] = array((object) array(
            'arguments' => (object) array(
                'torrents' => array(
                    (object) array(
                        'id' => 1,
                        'name' => 'Example'
                    )
                )
            )
        ));

        $responses[] = array((object) array(
            'result' => 'success'
        ));

        $responses[] = array((object) array(
            'result' => 'success',
            'arguments' => (object) array()
        ));

        return $responses;
    }
}
