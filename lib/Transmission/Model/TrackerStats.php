<?php
namespace Transmission\Model;

/**
 * @author Bilal Ghouri <bilalghouri@live.com>
 */
class TrackerStats extends AbstractModel
{
    /**
     * @var string
     */
    protected $host;

    /**
     * @var integer
     */
    protected $leecherCount;
	
	/**
     * @var integer
     */
    protected $seederCount;

    /**
     * @var string
     */
    protected $lastAnnounceResult;

    /**
     * @var string
     */
    protected $lastScrapeResult;

    /**
     * @param string $host
     */
    public function setHost($host)
    {
        $this->host =  (string) $host;
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }
	
    /**
     * @param string $lastAnnounceResult
     */
    public function setLastAnnounceResult($lastAnnounceResult)
    {
        $this->lastAnnounceResult =  (string) $lastAnnounceResult;
    }

    /**
     * @return string
     */
    public function getLastAnnounceResult()
    {
        return $this->lastAnnounceResult;
    }
	
	/**
     * @param string $lastScrapeResult
     */
    public function setLastScrapeResult($lastScrapeResult)
    {
        $this->lastScrapeResult =  (string) $lastScrapeResult;
    }

    /**
     * @return string
     */
    public function getLastScrapeResult()
    {
        return $this->lastScrapeResult;
    }

    /**
     * @param integer $seederCount
     */
    public function setSeederCount($seederCount)
    {
        $this->seederCount = (integer) $seederCount;
    }

    /**
     * @return integer
     */
    public function getSeederCount()
    {
        return $this->seederCount;
    }

    /**
     * @param integer $leecherCount
     */
    public function setLeecherCount($leecherCount)
    {
        $this->leecherCount = (integer) $leecherCount;
    }

    /**
     * @return integer
     */
    public function getLeecherCount()
    {
        return $this->leecherCount;
    }

    /**
     * {@inheritDoc}
     */
    public static function getMapping()
    {
        return array(
            'host' => 'host',
            'leecherCount' => 'leecherCount',
            'seederCount' => 'seederCount',
            'lastScrapeResult' => 'lastScrapeResult',
            'lastAnnounceResult' => 'lastAnnounceResult'
        );
    }
}
