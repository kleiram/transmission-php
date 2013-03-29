<?php
namespace Transmission\Test\Transformer;

use Transmission\Transformer\ModelTransformer;

class ModelTransformerTest extends \PHPUnit_Framework_TestCase
{
    public function testImplementsTransformerInterface()
    {
        $transformer = new ModelTransformer();

        $this->assertInstanceOf('Transmission\Transformer\TransformerInterface', $transformer);
    }

    public function testTransformsTorrents()
    {
        $transformer = new ModelTransformer();
        $torrents = $transformer->transform($this->getResponse());

        $this->assertCount(1, $torrents);

        $torrent = $torrents[0];

        $this->assertInstanceOf('Transmission\Model\Torrent', $torrent);
        $this->assertEquals(1, $torrent->getId());
        $this->assertEquals('example torrent', $torrent->getName());
        $this->assertEquals(100, $torrent->getSize());
        $this->assertInstanceOf('DateTime', $torrent->getDoneDate());
        $this->assertFiles($torrent->getFiles());
        $this->assertPeers($torrent->getPeers());
        $this->assertTrackers($torrent->getTrackers());
    }

    public function testExceptionWhenResultIsNotSuccess()
    {
        $this->setExpectedException('Transmission\Exception\InvalidResponseException');

        $transformer = new ModelTransformer();
        $transformer->transform((object) array('result' => 'Something went wrong'));
    }

    public function testExceptionWhenInvalidResponseReceived()
    {
        $this->setExpectedException('Transmission\Exception\InvalidResponseException');

        $transformer = new ModelTransformer();
        $transformer->transform((object) array('result' => 'success'));
    }

    protected function assertFiles(array $files)
    {
        $this->assertCount(1, $files);

        $file = $files[0];

        $this->assertEquals('Lorem ipsum', $file->getName());
        $this->assertEquals(10, $file->getCompleted());
        $this->assertEquals(100, $file->getSize());
    }

    protected function assertPeers(array $peers)
    {
        $this->assertCount(1, $peers);

        $peer = $peers[0];

        $this->assertEquals('example.org', $peer->getAddress());
        $this->assertEquals(10, $peer->getPort());
    }

    protected function assertTrackers(array $trackers)
    {
        $this->assertCount(1, $trackers);

        $tracker = $trackers[0];

        $this->assertEquals(1, $tracker->getId());
        $this->assertEquals('foo', $tracker->getAnnounce());
        $this->assertEquals('bar', $tracker->getScrape());
        $this->assertEquals(10, $tracker->getTier());
    }

    protected function getResponse()
    {
        return (object) array(
            'result' => 'success',
            'arguments' => array('torrents' => array($this->getTorrentData()))
        );
    }

    protected function getTorrentData()
    {
        return array(
            'id' => 1,
            'name' => 'example torrent',
            'doneDate' => 10,
            'size' => 100,
            'files' => array($this->getFileData()),
            'peers' => array($this->getPeerData()),
            'trackers' => array($this->getTrackerData())
        );
    }

    protected function getFileData()
    {
        return array(
            'name' => 'Lorem ipsum',
            'bytesCompleted' => 10,
            'length' => 100
        );
    }

    protected function getPeerData()
    {
        return array(
            'address' => 'example.org',
            'port' => 10
        );
    }

    protected function getTrackerData()
    {
        return array(
            'id' => 1,
            'announce' => 'foo',
            'scrape' => 'bar',
            'tier' => 10
        );
    }
}
