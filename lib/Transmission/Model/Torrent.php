<?php
namespace Transmission\Model;

/**
 * @author Ramon Kleiss <ramon@cubilon.nl>
 */
class Torrent implements ModelInterface
{
    const STATUS_STOPPED        = 0;
    const STATUS_CHECK_WAIT     = 1;
    const STATUS_CHECK          = 2;
    const STATUS_DOWNLOAD_WAIT  = 3;
    const STATUS_DOWNLOAD       = 4;
    const STATUS_SEED_WAIT      = 5;
    const STATUS_SEED           = 6;

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
    protected $size;

    /**
     * @var integer
     */
    protected $eta;

    /**
     * @var DateTime
     */
    protected $doneDate;

    /**
     * @var array
     */
    protected $files;

    /**
     * @var array
     */
    protected $peers;

    /**
     * @var array
     */
    protected $trackers;

    /**
     * @var integer
     */
    protected $status;

    /**
     * @var double
     */
    protected $percentDone;

    /**
     * @var integer
     */
    protected $downloadRate;

    /**
     * @var integer
     */
    protected $uploadRate;

    /**
     * {@inheritDoc}
     */
    public function getFieldMap()
    {
        return array(
            'id' => 'id',
            'name' => 'name',
            'size' => 'totalSize',
            'eta' => 'eta',
            'doneDate' => 'doneDate',
            'status' => 'status',
            'percentDone' => 'percentDone',
            'downloadRate' => 'rateDownload',
            'uploadRate' => 'rateUpload'
        );
    }

    /**
     * @param integer $id
     */
    public function setId($id)
    {
        $this->id = (integer) $id;
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = (string) $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param integer $size
     */
    public function setSize($size)
    {
        $this->size = (integer) $size;
    }

    /**
     * @return integer
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param integer $eta
     */
    public function setEta($eta)
    {
        $this->eta = (integer) $eta;
    }

    /**
     * @return integer
     */
    public function getEta()
    {
        return $this->eta;
    }

    /**
     * @param integer|DateTime $doneDate
     */
    public function setDoneDate($doneDate)
    {
        if ($doneDate instanceof \DateTime) {
            $this->doneDate = $doneDate;

            return;
        }

        $this->doneDate = \DateTime::createFromFormat('U', (integer) $doneDate);
    }

    /**
     * @return DateTime
     */
    public function getDoneDate()
    {
        return $this->doneDate;
    }

    /**
     * @param Transmission\Model\File $file
     */
    public function addFile(File $file)
    {
        $this->files[] = $file;
    }

    /**
     * @return array
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * @param Transmission\Model\Peer $peer
     */
    public function addPeer(Peer $peer)
    {
        $this->peers[] = $peer;
    }

    /**
     * @return array
     */
    public function getPeers()
    {
        return $this->peers;
    }

    /**
     * @param Transmission\Model\Tracker $tracker
     */
    public function addTracker(Tracker $tracker)
    {
        $this->trackers[] = $tracker;
    }

    /**
     * @return array
     */
    public function getTrackers()
    {
        return $this->trackers;
    }

    /**
     * @param integer $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param double $percentDone
     */
    public function setPercentDone($percentDone)
    {
        $this->percentDone = (double) $percentDone;
    }

    /**
     * @return double
     */
    public function getPercentDone()
    {
        return $this->percentDone;
    }

    /**
     * @var integer
     */
    public function setDownloadRate($downloadRate)
    {
        $this->downloadRate = (integer) $downloadRate;
    }

    /**
     * @return integer
     */
    public function getDownloadRate()
    {
        return $this->downloadRate;
    }

    /**
     * @param integer $uploadRate
     */
    public function setUploadRate($uploadRate)
    {
        $this->uploadRate = (integer) $uploadRate;
    }

    /**
     * @return integer
     */
    public function getUploadRate()
    {
        return $this->uploadRate;
    }
}
