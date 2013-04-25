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
            ->with(
                'torrent-get',
                array(
                    'fields' => array(
                        'id',
                        'name',
                        'status',
                        'finished',
                        'rateDownload',
                        'rateUpload',
                        'sizeWhenDone',
                        'percentDone',
                        'downloadDir',
                        'eta',
                        'files',
                        'trackers',
                    ),
                    'ids' => array(1)
                )
            )
            ->will($this->returnValue($this->loadFixture("get_torrent")));

        $torrent = Torrent::get(1, $client);

        $this->assertInstanceOf('Transmission\Torrent', $torrent);
        $this->assertEquals($client, $torrent->getClient());
        $this->assertEquals(1, $torrent->getId());
        $this->assertEquals('Example', $torrent->getName());
        $this->assertTrue($torrent->isStopped());
        $this->assertFalse($torrent->isDownloading());
        $this->assertFalse($torrent->isChecking());
        $this->assertFalse($torrent->isSeeding());
        $this->assertFalse($torrent->isFinished());
        $this->assertEquals(1000, $torrent->getDownloadRate());
        $this->assertEquals(50, $torrent->getUploadRate());
        $this->assertEquals(10000, $torrent->getSize());
        $this->assertInstanceOf('DateInterval', $torrent->getEta());
        $this->assertEquals(7200, $torrent->getEta()->s);
        $this->assertEquals(10.05, $torrent->getPercentDone());

        $this->assertInternalType('array', $torrent->getFiles());
        $this->assertCount(1, ($files = $torrent->getFiles()));
        $this->assertEquals('foo', $files[0]->getName());
        $this->assertEquals(1000, $files[0]->getSize());
        $this->assertEquals(0, $files[0]->getCompleted());

        $this->assertInternalType('array', $torrent->getTrackers());
        $this->assertCount(1, ($trackers = $torrent->getTrackers()));
        $this->assertEquals(1, $trackers[0]->getId());
        $this->assertEquals(1, $trackers[0]->getTier());
        $this->assertEquals('foo', $trackers[0]->getScrape());
        $this->assertEquals('bar', $trackers[0]->getAnnounce());

        $this->assertInternalType('array', $torrent->getPeers());
        $this->assertCount(1, ($peers = $torrent->getPeers()));
        $this->assertEquals('10.0.0.1', $peers[0]->getAddress());
        $this->assertEquals(54352, $peers[0]->getPort());
        $this->assertEquals('foo', $peers[0]->getClient());
        $this->assertFalse($peers[0]->isUtp());
        $this->assertTrue($peers[0]->isEncrypted());
        $this->assertTrue($peers[0]->isUploading());
        $this->assertTrue($peers[0]->isDownloading());
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

    /**
     * @test
     */
    public function shouldStartTorrent()
    {
        $response = (object) array(
            'arguments' => (object) array(),
            'result' => 'success'
        );

        $client = $this->getMock('Transmission\Client');
        $client
            ->expects($this->once())
            ->method('call')
            ->with(
                'torrent-start',
                array('ids' => array(1))
            )
            ->will($this->returnValue($response));

        $torrent = new Torrent($client);
        $torrent->setId(1);
        $torrent->start();
    }

    /**
     * @test
     */
    public function shouldStartTorrentNow()
    {
        $response = (object) array(
            'arguments' => (object) array(),
            'result' => 'success'
        );

        $client = $this->getMock('Transmission\Client');
        $client
            ->expects($this->once())
            ->method('call')
            ->with(
                'torrent-start-now',
                array('ids' => array(1))
            )
            ->will($this->returnValue($response));

        $torrent = new Torrent($client);
        $torrent->setId(1);
        $torrent->start(true);
    }

    /**
     * @test
     */
    public function shouldStopTorrent()
    {
        $response = (object) array(
            'arguments' => (object) array(),
            'result' => 'success'
        );

        $client = $this->getMock('Transmission\Client');
        $client
            ->expects($this->once())
            ->method('call')
            ->with(
                'torrent-stop',
                array('ids' => array(1))
            )
            ->will($this->returnValue($response));

        $torrent = new Torrent($client);
        $torrent->setId(1);
        $torrent->stop();
    }

    /**
     * @test
     */
    public function shouldVerifyTorrent()
    {
        $response = (object) array(
            'arguments' => (object) array(),
            'result' => 'success'
        );

        $client = $this->getMock('Transmission\Client');
        $client
            ->expects($this->once())
            ->method('call')
            ->with(
                'torrent-verify',
                array('ids' => array(1))
            )
            ->will($this->returnValue($response));

        $torrent = new Torrent($client);
        $torrent->setId(1);
        $torrent->verify();
    }

    /**
     * @test
     */
    public function shouldReannounceTorrent()
    {
        $response = (object) array(
            'arguments' => (object) array(),
            'result' => 'success'
        );

        $client = $this->getMock('Transmission\Client');
        $client
            ->expects($this->once())
            ->method('call')
            ->with(
                'torrent-reannounce',
                array('ids' => array(1))
            )
            ->will($this->returnValue($response));

        $torrent = new Torrent($client);
        $torrent->setId(1);
        $torrent->reannounce();
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
