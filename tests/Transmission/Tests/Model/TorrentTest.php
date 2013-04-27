<?php
namespace Transmission\Tests\Model;

use Transmission\Model\Torrent;
use Transmission\Util\PropertyMapper;

class TorrentTest extends \PHPUnit_Framework_TestCase
{
    protected $torrent;

    /**
     * @test
     */
    public function shouldImplementModelInterface()
    {
        $this->assertInstanceOf('Transmission\Model\ModelInterface', $this->getTorrent());
    }

    /**
     * @test
     */
    public function shouldHaveNonEmptyMapping()
    {
        $this->assertNotEmpty($this->getTorrent()->getMapping());
    }

    /**
     * @test
     */
    public function shouldBeCreatedFromMapping()
    {
        $source = (object) array(
            'id' => 1,
            'name' => 'foo',
            'files' => array(
                (object) array()
            ),
            'peers' => array(
                (object) array(),
                (object) array()
            ),
            'trackers' => array(
                (object) array(),
                (object) array(),
                (object) array()
            )
        );

        PropertyMapper::map($this->getTorrent(), $source);

        $this->assertEquals(1, $this->getTorrent()->getId());
        $this->assertEquals('foo', $this->getTorrent()->getName());
        $this->assertCount(1, $this->getTorrent()->getFiles());
        $this->assertCount(2, $this->getTorrent()->getPeers());
        $this->assertCount(3, $this->getTorrent()->getTrackers());
    }

    public function setup()
    {
        $this->torrent = new Torrent();
    }

    public function getTorrent()
    {
        return $this->torrent;
    }
}
