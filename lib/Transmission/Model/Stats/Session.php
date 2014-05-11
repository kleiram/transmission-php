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
     *
     * @return self
     */
    public function setActiveTorrentCount($activeTorrentCount)
    {
        $this->activeTorrentCount = $activeTorrentCount;

        return $this;
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
     *
     * @return self
     */
    public function setDownloadSpeed($downloadSpeed)
    {
        $this->downloadSpeed = $downloadSpeed;

        return $this;
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
     *
     * @return self
     */
    public function setPausedTorrentCount($pausedTorrentCount)
    {
        $this->pausedTorrentCount = $pausedTorrentCount;

        return $this;
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
     *
     * @return self
     */
    public function setTorrentCount($torrentCount)
    {
        $this->torrentCount = $torrentCount;

        return $this;
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
     *
     * @return self
     */
    public function setUploadSpeed($uploadSpeed)
    {
        $this->uploadSpeed = $uploadSpeed;

        return $this;
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
     *
     * @return self
     */
    public function setCumulative(Stats $cumulative)
    {
        $this->cumulative = $cumulative;

        return $this;
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
     *
     * @return self
     */
    public function setCurrent(Stats $current)
    {
        $this->current = $current;

        return $this;
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
