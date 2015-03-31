<?php
namespace Transmission\Tests\Model;

use Transmission\Model\TrackerStats;
use Transmission\Util\PropertyMapper;

class TrackerStatsTest extends \PHPUnit_Framework_TestCase
{
    protected $trackerStats;

    /**
     * @test
     */
    public function shouldImplementModelInterface()
    {
        $this->assertInstanceOf('Transmission\Model\ModelInterface', $this->getTrackerStats());
    }

    /**
     * @test
     */
    public function shouldHaveNonEmptyMapping()
    {
        $this->assertNotEmpty($this->getTrackerStats()->getMapping());
    }

    /**
     * @test
     */
    public function shouldBeCreatedFromMapping()
    {
        $source = (object) array(
            'host' => 'test',
            'leecherCount' => 1,
            'seederCount' => 2,
            'lastScrapeResult' => 'foo',
            'lastAnnounceResult' => 'bar'
        );

        PropertyMapper::map($this->getTrackerStats(), $source);

        $this->assertEquals('test', $this->getTrackerStats()->getHost());
        $this->assertEquals(1, $this->getTrackerStats()->getLeecherCount());
        $this->assertEquals(2, $this->getTrackerStats()->getSeederCount());
        $this->assertEquals('foo', $this->getTrackerStats()->getLastScrapeResult());
        $this->assertEquals('bar', $this->getTrackerStats()->getLastAnnounceResult());
    }

    public function setup()
    {
        $this->trackerStats = new TrackerStats();
    }

    private function getTrackerStats()
    {
        return $this->trackerStats;
    }
}
