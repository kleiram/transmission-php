<?php
namespace Transmission\Model\Stats;

use Transmission\Model\AbstractModel;

/**
 * @author Joysen Chellem
 */
class Session extends AbstractModel
{
    private $activeTorrentCount;
    private $downloadSpeed;
    private $pausedTorrentCount;
    private $torrentCount;
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
     * @return mixed
     */
    public function getActiveTorrentCount()
    {
        return $this->activeTorrentCount;
    }

    /**
     * Sets the value of activeTorrentCount.
     *
     * @param mixed $activeTorrentCount the active torrent count
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
     * @return mixed
     */
    public function getDownloadSpeed()
    {
        return $this->downloadSpeed;
    }

    /**
     * Sets the value of downloadSpeed.
     *
     * @param mixed $downloadSpeed the download speed
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
     * @return mixed
     */
    public function getPausedTorrentCount()
    {
        return $this->pausedTorrentCount;
    }

    /**
     * Sets the value of pausedTorrentCount.
     *
     * @param mixed $pausedTorrentCount the paused torrent count
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
     * @return mixed
     */
    public function getTorrentCount()
    {
        return $this->torrentCount;
    }

    /**
     * Sets the value of torrentCount.
     *
     * @param mixed $torrentCount the torrent count
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
     * @return mixed
     */
    public function getUploadSpeed()
    {
        return $this->uploadSpeed;
    }

    /**
     * Sets the value of uploadSpeed.
     *
     * @param mixed $uploadSpeed the upload speed
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
