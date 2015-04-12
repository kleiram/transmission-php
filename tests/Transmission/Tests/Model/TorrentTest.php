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
            'eta' => 10,
            'sizeWhenDone' => 10000,
            'name' => 'foo',
            'hashString' => 'bar',
            'status' => 0,
            'isFinished' => false,
            'rateUpload' => 10,
            'rateDownload' => 100,
            'downloadDir' => '/home/foo',
            'files' => array(
                (object) array()
            ),
            'peers' => array(
                (object) array(),
                (object) array()
            ),
            'peersConnected' => 10,
            'startDate' => 1427583510,
            'trackers' => array(
                (object) array(),
                (object) array(),
                (object) array()
            ),
            'trackerStats' => array(
                (object) array(),
                (object) array(),
                (object) array()
            )
        );

        PropertyMapper::map($this->getTorrent(), $source);

        $this->assertEquals(1, $this->getTorrent()->getId());
        $this->assertEquals(10, $this->getTorrent()->getEta());
        $this->assertEquals(10000, $this->getTorrent()->getSize());
        $this->assertEquals('foo', $this->getTorrent()->getName());
        $this->assertEquals('bar', $this->getTorrent()->getHash());
        $this->assertEquals(0, $this->getTorrent()->getStatus());
        $this->assertFalse($this->getTorrent()->isFinished());
        $this->assertEquals(10, $this->getTorrent()->getUploadRate());
        $this->assertEquals(100, $this->getTorrent()->getDownloadRate());
        $this->assertEquals('/home/foo', $this->getTorrent()->getDownloadDir());
        $this->assertCount(1, $this->getTorrent()->getFiles());
        $this->assertCount(2, $this->getTorrent()->getPeers());
        $this->assertCount(3, $this->getTorrent()->getTrackers());
    }

    /**
     * @test
     */
    public function shouldBeDoneWhenFinishedFlagIsSet()
    {
        $this->getTorrent()->setFinished(true);

        $this->assertTrue($this->getTorrent()->isFinished());
    }

    /**
     * @test
     */
    public function shouldBeDoneWhenPercentDoneIs100Percent()
    {
        $this->getTorrent()->setPercentDone(1);

        $this->assertTrue($this->getTorrent()->isFinished());
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
