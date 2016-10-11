<?php
namespace Transmission\Model;

use Transmission\Util\PropertyMapper;

/**
 * @author Ramon Kleiss <ramon@cubilon.nl>
 */
class Torrent extends AbstractModel implements TorrentInterface
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var integer
     */
    protected $eta;

    /**
     * @var integer
     */
    protected $size;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $hash;

    /**
     * @var Status
     */
    protected $status;

    /**
     * @var boolean
     */
    protected $finished;

    /**
     * @var integer
     */
    protected $startDate;

    /**
     * @var integer
     */
    protected $uploadRate;

    /**
     * @var integer
     */
    protected $downloadRate;

    /**
     * @var integer
     */
    protected $peersConnected;

    /**
     * @var double
     */
    protected $percentDone;

    /**
     * @var array
     */
    protected $files = array();

    /**
     * @var array
     */
    protected $peers = array();

    /**
     * @var array
     */
    protected $trackers = array();

    /**
     * @var array
     */
    protected $trackerStats = array();

    /**
     * @var double
     */
    protected $uploadRatio;

    /**
     * @var string
     */
    protected $downloadDir;

    /**
     * @var integer
     */
    protected $downloadedEver;

    /**
     * @var integer
     */
    protected $uploadedEver;

    /**
     * {@inheritDoc}
     */
    public function setId($id)
    {
        $this->id = (integer) $id;
    }

    /**
     * {@inheritDoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritDoc}
     */
    public function setEta($eta)
    {
        $this->eta = (integer) $eta;
    }

    /**
     * {@inheritDoc}
     */
    public function getEta()
    {
        return $this->eta;
    }

    /**
     * {@inheritDoc}
     */
    public function setSize($size)
    {
        $this->size = (integer) $size;
    }

    /**
     * {@inheritDoc}
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * {@inheritDoc}
     */
    public function setName($name)
    {
        $this->name = (string) $name;
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritDoc}
     */
    public function setHash($hash)
    {
        $this->hash = (string) $hash;
    }

    /**
     * {@inheritDoc}
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * {@inheritDoc}
     */
    public function setStatus($status)
    {
        $this->status = new Status($status);
    }

    /**
     * {@inheritDoc}
     */
    public function getStatus()
    {
        return $this->status->getValue();
    }

    /**
     * {@inheritDoc}
     */
    public function setFinished($finished)
    {
        $this->finished = (boolean) $finished;
    }

    /**
     * {@inheritDoc}
     */
    public function isFinished()
    {
        return ($this->finished || (int) $this->getPercentDone() == 100);
    }

    /**
     * {@inheritDoc}
     */
    public function setStartDate($startDate)
    {
        $this->startDate = (integer) $startDate;
    }

    /**
     * {@inheritDoc}
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * {@inheritDoc}
     */
    public function setUploadRate($rate)
    {
        $this->uploadRate = (integer) $rate;
    }

    /**
     * {@inheritDoc}
     */
    public function getUploadRate()
    {
        return $this->uploadRate;
    }

    /**
     * {@inheritDoc}
     */
    public function setDownloadRate($rate)
    {
        $this->downloadRate = (integer) $rate;
    }

    /**
     * {@inheritDoc}
     */
    public function setPeersConnected($peersConnected)
    {
        $this->peersConnected = (integer) $peersConnected;
    }

    /**
     * {@inheritDoc}
     */
    public function getPeersConnected()
    {
        return $this->peersConnected;
    }

    /**
     * {@inheritDoc}
     */
    public function getDownloadRate()
    {
        return $this->downloadRate;
    }

    /**
     * {@inheritDoc}
     */
    public function setPercentDone($done)
    {
        $this->percentDone = (double) $done;
    }

    /**
     * {@inheritDoc}
     */
    public function getPercentDone()
    {
        return $this->percentDone * 100.0;
    }

    /**
     * {@inheritDoc}
     */
    public function setFiles(array $files)
    {
        $this->files = array_map(function ($file) {
            return PropertyMapper::map(new File(), $file);
        }, $files);
    }

    /**
     * {@inheritDoc}
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * {@inheritDoc}
     */
    public function setPeers(array $peers)
    {
        $this->peers = array_map(function ($peer) {
            return PropertyMapper::map(new Peer(), $peer);
        }, $peers);
    }

    /**
     * {@inheritDoc}
     */
    public function getPeers()
    {
        return $this->peers;
    }

    /**
     * {@inheritDoc}
     */
    public function setTrackerStats(array $trackerStats)
    {
        $this->trackerStats = array_map(function ($trackerStats) {
            return PropertyMapper::map(new TrackerStats(), $trackerStats);
        }, $trackerStats);
    }

    /**
     * {@inheritDoc}
     */
    public function getTrackerStats()
    {
        return $this->trackerStats;
    }

    /**
     * {@inheritDoc}
     */
    public function setTrackers(array $trackers)
    {
        $this->trackers = array_map(function ($tracker) {
            return PropertyMapper::map(new Tracker(), $tracker);
        }, $trackers);
    }

    /**
     * {@inheritDoc}
     */
    public function getTrackers()
    {
        return $this->trackers;
    }

    /**
     * {@inheritDoc}
     */
    public function setUploadRatio($ratio)
    {
        $this->uploadRatio = (double) $ratio;
    }

    /**
     * {@inheritDoc}
     */
    public function getUploadRatio()
    {
        return $this->uploadRatio;
    }

    /**
     * {@inheritDoc}
     */
    public function isStopped()
    {
        return $this->status->isStopped();
    }

    /**
     * {@inheritDoc}
     */
    public function isChecking()
    {
        return $this->status->isChecking();
    }

    /**
     * {@inheritDoc}
     */
    public function isDownloading()
    {
        return $this->status->isDownloading();
    }

    /**
     * {@inheritDoc}
     */
    public function isSeeding()
    {
        return $this->status->isSeeding();
    }

    /**
     * {@inheritDoc}
     */
    public function getDownloadDir()
    {
        return $this->downloadDir;
    }

    /**
     * {@inheritDoc}
     */
    public function setDownloadDir($downloadDir)
    {
        $this->downloadDir = $downloadDir;
    }

    /**
     * {@inheritDoc}
     */
    public function getDownloadedEver()
    {
        return $this->downloadedEver;
    }

    /**
     * {@inheritDoc}
     */
    public function setDownloadedEver($downloadedEver)
    {
        $this->downloadedEver = $downloadedEver;
    }

    /**
     * {@inheritDoc}
     */
    public function getUploadedEver()
    {
        return $this->uploadedEver;
    }

    /**
     * {@inheritDoc}
     */
    public function setUploadedEver($uploadedEver)
    {
        $this->uploadedEver = $uploadedEver;
    }

    /**
     * {@inheritDoc}
     */
    public static function getMapping()
    {
        return array(
            'id' => 'id',
            'eta' => 'eta',
            'sizeWhenDone' => 'size',
            'name' => 'name',
            'status' => 'status',
            'isFinished' => 'finished',
            'rateUpload' => 'uploadRate',
            'rateDownload' => 'downloadRate',
            'percentDone' => 'percentDone',
            'files' => 'files',
            'peers' => 'peers',
            'peersConnected' => 'peersConnected',
            'trackers' => 'trackers',
            'trackerStats' => 'trackerStats',
            'startDate' => 'startDate',
            'uploadRatio' => 'uploadRatio',
            'hashString' => 'hash',
            'downloadDir' => 'downloadDir',
            'downloadedEver' => 'downloadedEver',
            'uploadedEver' => 'uploadedEver'
        );
    }
}
