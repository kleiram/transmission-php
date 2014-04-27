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
    private $cumulativeStats;
    private $currentStats;

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
     * Gets the value of cumulativeStats.
     *
     * @return mixed
     */
    public function getCumulativeStats()
    {
        return $this->cumulativeStats;
    }

    /**
     * Sets the value of cumulativeStats.
     *
     * @param mixed $cumulativeStats the cumulative stats
     *
     * @return self
     */
    public function setCumulativeStats($cumulativeStats)
    {
        $this->cumulativeStats = $cumulativeStats;

        return $this;
    }

    /**
     * Gets the value of currentStats.
     *
     * @return mixed
     */
    public function getCurrentStats()
    {
        return $this->currentStats;
    }

    /**
     * Sets the value of currentStats.
     *
     * @param mixed $currentStats the current stats
     *
     * @return self
     */
    public function setCurrentStats($currentStats)
    {
        $this->currentStats = $currentStats;

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
            'cumulative-stats'=>'cumulativeStats',
            'current-stats' => 'currentStats',
        );
    }
}
