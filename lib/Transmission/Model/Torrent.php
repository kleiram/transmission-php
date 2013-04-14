<?php
namespace Transmission\Model;

use Transmission\Client;

/**
 * Represents a torrent in Transmissions download queue
 *
 * @author Ramon Kleiss <ramon@cubilon.nl>
 */
class Torrent extends AbstractModel
{
    /**
     * @var integer
     */
    const STATUS_STOPPED = 0;

    /**
     * @var integer
     */
    const STATUS_CHECK = 2;

    /**
     * @var integer
     */
    const STATUS_DOWNLOAD = 4;

    /**
     * @var integer
     */
    const STATUS_SEED = 6;

    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var integer
     */
    protected $status;

    /**
     * @var boolean
     */
    protected $finished;

    /**
     * @var array
     */
    protected $files;

    /**
     * @var array
     */
    protected $trackers;

    /**
     * @var array
     */
    protected $peers;

    /**
     * @var integer
     */
    protected $downloadRate;

    /**
     * @var integer
     */
    protected $uploadRate;

    /**
     * @var integer
     */
    protected $size;

    /**
     * @var integer
     */
    protected $eta;

    /**
     * @var double
     */
    protected $percentDone;

    /**
     * Constructor
     *
     * @param Transmission\Client $client The client used to connect to
     *                            Transmission
     */
    public function __construct(Client $client = null)
    {
        parent::__construct($client);

        $this->peers = array();
        $this->files = array();
        $this->tracker = array();
    }

    /**
     * Set the ID of the torrent
     *
     * @param integer $id The ID of the torrent
     */
    public function setId($id)
    {
        $this->id = (integer) $id;
    }

    /**
     * Get the ID of the torrent
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the name of the torrent
     *
     * @param string $name The name of the torrent
     */
    public function setName($name)
    {
        $this->name = (string) $name;
    }

    /**
     * Get the name of the torrent
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the status of the torrent
     *
     * @param integer $status
     */
    public function setStatus($status)
    {
        $this->status = (integer) $status;
    }

    /**
     * Get the status of the torrent
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Check if the torrent is stopped
     *
     * @return boolean
     */
    public function isStopped()
    {
        return $this->getStatus() === self::STATUS_STOPPED;
    }

    /**
     * Check if Transmission is checking the files downloaded using this torrent
     *
     * @return boolean
     */
    public function isChecking()
    {
        return $this->getStatus() === self::STATUS_CHECK;
    }

    /**
     * Check if Transmission is downloading this torrent
     *
     * @return boolean
     */
    public function isDownloading()
    {
        return $this->getStatus() === self::STATUS_DOWNLOAD;
    }

    /**
     * Check if this torrent is being seeded
     *
     * @return boolean
     */
    public function isSeeding()
    {
        return $this->getStatus() === self::STATUS_SEED;
    }

    /**
     * Set if this torrent is finished downloading
     *
     * @param boolean $finished Whether the torrent is finished
     */
    public function setFinished($finished)
    {
        $this->finished = (boolean) $finished;
    }

    /**
     * Check if this torrent has finished downloading
     *
     * @return boolean
     */
    public function isFinished()
    {
        return $this->finished;
    }

    /**
     * Set the download rate (in bytes per second) that this torrent
     * is being downloaded
     *
     * @param integer $downloadRate The download rate (in B/s)
     */
    public function setDownloadRate($downloadRate)
    {
        $this->downloadRate = (integer) $downloadRate;
    }

    /**
     * Get the download rate of this torrent (in B/s)
     *
     * @return integer
     */
    public function getDownloadRate()
    {
        return $this->downloadRate;
    }

    /**
     * Set the upload rate (in B/s) that this torrent is being uploaded
     *
     * @param integer $uploadRate The upload rate (in B/s)
     */
    public function setUploadRate($uploadRate)
    {
        $this->uploadRate = (integer) $uploadRate;
    }

    /**
     * Get the upload rate (in B/s) that this torrent is being uploaded
     *
     * @return integer
     */
    public function getUploadRate()
    {
        return $this->uploadRate;
    }

    /**
     * Set the size of this download
     *
     * @param integer $size The size of the download
     */
    public function setSize($size)
    {
        $this->size = (integer) $size;
    }

    /**
     * Get the size of this download
     *
     * @return integer
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set the ETA (in seconds) until this torrent is done downloading
     *
     * @param integer $eta
     */
    public function setEta($eta)
    {
        $this->eta = new \DateInterval(
            sprintf('PT%dS'
                ($eta > -1) ? $eta : 0
            )
        );
    }

    /**
     * Get the ETA until this torrent is done downloading
     *
     * @return DateInterval
     */
    public function getEta()
    {
        return $this->eta;
    }

    /**
     * Set the percentage of the torrent that is done downloading
     *
     * @param double $percentDone The percentage that is done downloading
     */
    public function setPercentDone($percentDone)
    {
        $this->percentDone = (double) $percentDone;
    }

    /**
     * Get the percentage of the torrent that is done downloading
     *
     * @return double
     */
    public function getPercentDone()
    {
        return $this->percentDone;
    }


    /**
     * Add a file that this torrent downloads
     *
     * @param Transmission\Model\File $file The file this torrent downloads
     */
    public function addFile(File $file)
    {
        $this->files[] = $file;
    }

    /**
     * Get the files that are being downloaded by this torrent
     *
     * @return array
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * Add a tracker that is used to download this torrent
     *
     * @param Transmission\Model\Tracker $tracker The tracker used
     */
    public function addTracker(Tracker $tracker)
    {
        $this->trackers[] = $tracker;
    }

    /**
     * Get the trackers that are used to download this torrent
     *
     * @return array
     */
    public function getTrackers()
    {
        return $this->trackers;
    }

    /**
     * Add a peer that is connect with this torrent
     *
     * @param Transmission\Model\Peer $peer
     */
    public function addPeer(Peer $peer)
    {
        $this->peers[] = $peer;
    }

    /**
     * Get the peers that are connected to this torrent
     *
     * @return array
     */
    public function getPeers()
    {
        return $this->peers;
    }

    /**
     * @return array
     */
    protected static function getMapping()
    {
        return array(
            'id' => 'id',
            'name' => 'name',
            'status' => 'status',
            'finished' => 'finished',
            'rateDownload' => 'downloadRate',
            'rateUpload' => 'uploadRate',
            'sizeWhenDone' => 'size',
            'percentDone' => 'percentDone',
            'eta' => 'eta',
            'files' => null,
            'trackers' => null
        );
    }
}
