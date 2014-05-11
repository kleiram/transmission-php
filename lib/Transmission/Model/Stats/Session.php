<?php
namespace Transmission\Model\Stats;

use Transmission\Model\AbstractModel;

/**
 * @author Joysen Chellem
 */
class Session extends AbstractModel
{
    /**
     * @var integer
     */
    private $activeTorrentCount;

    /**
     * @var integer
     */
    private $downloadSpeed;

    /**
     * @var integer
     */
    private $pausedTorrentCount;

    /**
     * @var integer
     */
    private $torrentCount;

    /**
     * @var integer
     */
    private $uploadSpeed;

    /**
     * @var Stats
     */
    private $cumulative;

    /**
     * @var Stats
     */
    private $current;

    /**
     * Gets the value of activeTorrentCount.
     *
     * @return integer
     */
    public function getActiveTorrentCount()
    {
        return $this->activeTorrentCount;
    }

    /**
     * Sets the value of activeTorrentCount.
     *
     * @param integer $activeTorrentCount the active torrent count
     */
    public function setActiveTorrentCount($activeTorrentCount)
    {
        $this->activeTorrentCount = $activeTorrentCount;
    }

    /**
     * Gets the value of downloadSpeed.
     *
     * @return integer
     */
    public function getDownloadSpeed()
    {
        return $this->downloadSpeed;
    }

    /**
     * Sets the value of downloadSpeed.
     *
     * @param integer $downloadSpeed the download speed
     */
    public function setDownloadSpeed($downloadSpeed)
    {
        $this->downloadSpeed = $downloadSpeed;
    }

    /**
     * Gets the value of pausedTorrentCount.
     *
     * @return integer
     */
    public function getPausedTorrentCount()
    {
        return $this->pausedTorrentCount;
    }

    /**
     * Sets the value of pausedTorrentCount.
     *
     * @param integer $pausedTorrentCount the paused torrent count
     */
    public function setPausedTorrentCount($pausedTorrentCount)
    {
        $this->pausedTorrentCount = $pausedTorrentCount;
    }

    /**
     * Gets the value of torrentCount.
     *
     * @return integer
     */
    public function getTorrentCount()
    {
        return $this->torrentCount;
    }

    /**
     * Sets the value of torrentCount.
     *
     * @param integer $torrentCount the torrent count
     */
    public function setTorrentCount($torrentCount)
    {
        $this->torrentCount = $torrentCount;
    }

    /**
     * Gets the value of uploadSpeed.
     *
     * @return integer
     */
    public function getUploadSpeed()
    {
        return $this->uploadSpeed;
    }

    /**
     * Sets the value of uploadSpeed.
     *
     * @param integer $uploadSpeed the upload speed
     */
    public function setUploadSpeed($uploadSpeed)
    {
        $this->uploadSpeed = $uploadSpeed;
    }

    /**
     * Gets the value of cumulative.
     *
     * @return Stats
     */
    public function getCumulative()
    {
        return $this->cumulative;
    }

    /**
     * Sets the value of cumulative.
     *
     * @param Stats $cumulative the cumulative
     */
    public function setCumulative(Stats $cumulative)
    {
        $this->cumulative = $cumulative;
    }

    /**
     * Gets the value of current.
     *
     * @return Stats
     */
    public function getCurrent()
    {
        return $this->current;
    }

    /**
     * Sets the value of current.
     *
     * @param Stats $current the current
     */
    public function setCurrent(Stats $current)
    {
        $this->current = $current;
    }

    /**
     * {@inheritDoc}
     */
    public static function getMapping()
    {
        return array(
            'activeTorrentCount' => 'activeTorrentCount',
            'downloadSpeed' => 'downloadSpeed',
            'pausedTorrentCount' => 'pausedTorrentCount',
            'torrentCount' => 'torrentCount',
            'uploadSpeed' => 'uploadSpeed',
            'cumulative-stats'=>'cumulative',
            'current-stats' => 'current',
        );
    }
}
