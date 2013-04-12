<?php
namespace Transmission\Tests;

use Transmission\Torrent;

class TorrentTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldGetAllTorrents()
    {
        $client = $this->getMock('Transmission\Client');
        $client
            ->expects($this->once())
            ->method('call')
            ->with('torrent-get')
            ->will($this->returnValue($this->loadFixture('get_all_torrents')));

        $torrents = Torrent::all($client);

        $this->assertInternalType('array', $torrents);
        $this->assertCount(2, $torrents);

        $this->assertEquals(1, $torrents[0]->getId());
        $this->assertEquals('Example 1', $torrents[0]->getName());

        $this->assertEquals(2, $torrents[1]->getId());
        $this->assertEquals('Example 2', $torrents[1]->getName());
    }

    /**
     * @test
     * @expectedException RuntimeException
     */
    public function shouldThrowExceptionOnUnsuccesfullAllTorrentsResultMessage()
    {
        $response = (object) array(
            'result' => 'Something went wrong'
        );

        $client = $this->getMock('Transmission\Client');
        $client
            ->expects($this->once())
            ->method('call')
            ->will($this->returnValue($response));

        Torrent::all($client);
    }

    /**
     * @test
     * @expectedException Transmission\Exception\InvalidResponseException
     * @dataProvider invalidTorrentAllProvider
     */
    public function shouldThrowExceptionOnMissingFieldsInAllTorrentsRequest($response)
    {
        $client = $this->getMock('Transmission\Client');
        $client
            ->expects($this->once())
            ->method('call')
            ->will($this->returnValue($response));

        Torrent::all($client);
    }

    /**
     * @test
     */
    public function shouldGetTorrent()
    {
        $client = $this->getMock('Transmission\Client');
        $client
            ->expects($this->once())
            ->method('call')
            ->with('torrent-get')
            ->will($this->returnValue($this->loadFixture("get_torrent")));

        $torrent = Torrent::get(1, $client);

        $this->assertInstanceOf('Transmission\Torrent', $torrent);
        $this->assertEquals($client, $torrent->getClient());
        $this->assertEquals(1, $torrent->getId());
        $this->assertEquals('Example', $torrent->getName());
    }

    /**
     * @test
     * @expectedException RuntimeException
     */
    public function shouldThrowExceptionOnUnsuccesfullGetTorrentResultMessage()
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
     * @dataProvider invalidTorrentGetResponseProvider
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

    /**
     * @test
     */
    public function shouldAddTorrentsByFilename()
    {
        $client = $this->getMock('Transmission\Client');
        $client
            ->expects($this->once())
            ->method('call')
            ->with(
                'torrent-add',
                array('torrent' => 'foo')
            )
            ->will($this->returnValue($this->loadFixture('add_torrent')));

        $torrent = Torrent::add('foo', $client);

        $this->assertInstanceOf('Transmission\Torrent', $torrent);
        $this->assertEquals($client, $torrent->getClient());
        $this->assertEquals(1, $torrent->getId());
        $this->assertEquals('Some+Added+Torrent', $torrent->getName());
    }

    /**
     * @test
     */
    public function shouldAddTorrentsByMetaInfo()
    {
        $client = $this->getMock('Transmission\Client');
        $client
            ->expects($this->once())
            ->method('call')
            ->with(
                'torrent-add',
                array('metainfo' => sha1('foo'))
            )
            ->will($this->returnValue($this->loadFixture('add_torrent')));

        $torrent = Torrent::add(sha1('foo'), $client, true);

        $this->assertInstanceOf('Transmission\Torrent', $torrent);
        $this->assertEquals($client, $torrent->getClient());
        $this->assertEquals(1, $torrent->getId());
        $this->assertEquals('Some+Added+Torrent', $torrent->getName());
    }

    /**
     * @test
     * @expectedException RuntimeException
     */
    public function shouldThrowExceptionOnUnsuccesfullAddTorrentResultMessage()
    {
        $response = (object) array(
            'result' => 'Something went wrong'
        );

        $client = $this->getMock('Transmission\Client');
        $client
            ->expects($this->once())
            ->method('call')
            ->will($this->returnValue($response));

        Torrent::add('foo', $client);
    }

    /**
     * @test
     * @expectedException Transmission\Exception\InvalidResponseException
     * @dataProvider invalidTorrentAddResponseProvider
     */
    public function shouldThrowExceptionOnMissingFieldsInAddTorrentRequest($response)
    {
        $client = $this->getMock('Transmission\Client');
        $client
            ->expects($this->once())
            ->method('call')
            ->will($this->returnValue($response));

        Torrent::add('foo', $client);
    }

    /**
     * @test
     */
    public function shouldRemoveTorrents()
    {
        $client = $this->getMock('Transmission\Client');
        $client
            ->expects($this->once())
            ->method('call')
            ->with(
                'torrent-remove',
                array(
                    'ids' => array(1),
                    'delete-local-data' => false
                )
            )
            ->will($this->returnValue($this->loadFixture('remove_torrent')));

        $torrent = new Torrent($client);
        $torrent->setId(1);
        $torrent->delete();
    }

    /**
     * @test
     * @expectedException RuntimeException
     */
    public function shouldThrowExceptionOnUnsuccesfullRemoveTorrentResultMessage()
    {
        $response = (object) array(
            'result' => 'Something went wrong'
        );

        $client = $this->getMock('Transmission\Client');
        $client
            ->expects($this->once())
            ->method('call')
            ->will($this->returnValue($response));

        $torrent = new Torrent($client);
        $torrent->setId(1);
        $torrent->delete();
    }

    /**
     * @test
     * @expectedException Transmission\Exception\InvalidResponseException
     */
    public function shouldThrowExceptionOnMissingFieldsInRemoveTorrentRequest()
    {
        $response = (object) array();

        $client = $this->getMock('Transmission\Client');
        $client
            ->expects($this->once())
            ->method('call')
            ->will($this->returnValue($response));

        $torrent = new Torrent($client);
        $torrent->setId(1);
        $torrent->delete();
    }

    public function invalidTorrentAllProvider()
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

    public function invalidTorrentGetResponseProvider()
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

    public function invalidTorrentAddResponseProvider()
    {
        $responses = array();

        $responses[] = array((object) array(
            'arguments' => (object) array(
                'torrent-added' => array()
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

    protected function loadFixture($fixture)
    {
        $path = __DIR__."/../../fixtures/". $fixture .".json";

        if (file_exists($path)) {
            return json_decode(file_get_contents($path));
        }

        return (object) array();
    }
}
