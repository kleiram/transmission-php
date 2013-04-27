<?php
namespace Transmission\Tests\Model;

use Transmission\Model\Torrent;
use Transmission\Util\PropertyMapper;
use Symfony\Component\PropertyAccess\PropertyAccess;

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
            'status' => 0,
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
        $this->assertEquals(0, $this->getTorrent()->getStatus());
        $this->assertCount(1, $this->getTorrent()->getFiles());
        $this->assertCount(2, $this->getTorrent()->getPeers());
        $this->assertCount(3, $this->getTorrent()->getTrackers());
    }

    /**
     * @test
     * @dataProvider statusProvider
     */
    public function shouldHaveConvenienceMethods($status, $method)
    {
        $methods = array('stopped', 'checking', 'downloading', 'seeding');
        $accessor = PropertyAccess::getPropertyAccessor();
        $this->getTorrent()->setStatus($status);

        $methods = array_filter($methods, function ($value) use ($method) {
            return $method !== $value;
        });

        $this->assertTrue($accessor->getValue($this->getTorrent(), $method));
        foreach ($methods as $m) {
            $this->assertFalse($accessor->getValue($this->getTorrent(), $m), $m);
        }
    }

    public function statusProvider()
    {
        return array(
            array(0, 'stopped'),
            array(1, 'checking'),
            array(2, 'checking'),
            array(3, 'downloading'),
            array(4, 'downloading'),
            array(5, 'seeding'),
            array(6, 'seeding')
        );
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
