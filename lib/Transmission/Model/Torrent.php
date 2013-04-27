<?php
namespace Transmission\Model;

use Transmission\Util\PropertyMapper;

/**
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
    const STATUS_CHECK_WAIT = 1;

    /**
     * @var integer
     */
    const STATUS_CHECK = 2;

    /**
     * @var integer
     */
    const STATUS_DOWNLOAD_WAIT = 3;

    /**
     * @var integer
     */
    const STATUS_DOWNLOAD = 4;

    /**
     * @var integer
     */
    const STATUS_SEED_WAIT = 5;

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
     * @var integer
     */
    protected $uploadRate;

    /**
     * @var integer
     */
    protected $downloadRate;

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
     * @param integer $status
     */
    public function setStatus($status)
    {
        $this->status = (integer) $status;
    }

    /**
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param boolean $finished
     */
    public function setFinished($finished)
    {
        $this->finished = (boolean) $finished;
    }

    /**
     * @return boolean
     */
    public function isFinished()
    {
        return $this->finished;
    }

    /**
     * @var integer $rate
     */
    public function setUploadRate($rate)
    {
        $this->uploadRate = (integer) $rate;
    }

    /**
     * @return integer
     */
    public function getUploadRate()
    {
        return $this->uploadRate;
    }

    /**
     * @param integer $rate
     */
    public function setDownloadRate($rate)
    {
        $this->downloadRate = (integer) $rate;
    }

    /**
     * @return integer
     */
    public function getDownloadRate()
    {
        return $this->downloadRate;
    }

    /**
     * @param array $files
     */
    public function setFiles(array $files)
    {
        $this->files = array();

        foreach ($files as $file) {
            $this->files[] = PropertyMapper::map(new File(), $file);
        }
    }

    /**
     * @return array
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * @param array $peers
     */
    public function setPeers(array $peers)
    {
        $this->peers = array();

        foreach ($peers as $peer) {
            $this->peers[] = PropertyMapper::map(new Peer(), $peer);
        }
    }

    /**
     * @return array
     */
    public function getPeers()
    {
        return $this->peers;
    }

    /**
     * @param array $trackers
     */
    public function setTrackers(array $trackers)
    {
        $this->trackers = array();

        foreach ($trackers as $tracker) {
            $this->trackers[] = PropertyMapper::map(new Tracker(), $tracker);
        }
    }

    /**
     * @return array
     */
    public function getTrackers()
    {
        return $this->trackers;
    }

    /**
     * @return boolean
     */
    public function isStopped()
    {
        return $this->getStatus() == self::STATUS_STOPPED;
    }

    /**
     * @return boolean
     */
    public function isChecking()
    {
        return ($this->getStatus() == self::STATUS_CHECK ||
                $this->getStatus() == self::STATUS_CHECK_WAIT);
    }

    /**
     * @return boolean
     */
    public function isDownloading()
    {
        return ($this->getStatus() == self::STATUS_DOWNLOAD ||
                $this->getStatus() == self::STATUS_DOWNLOAD_WAIT);
    }

    /**
     * @return boolean
     */
    public function isSeeding()
    {
        return ($this->getStatus() == self::STATUS_SEED ||
                $this->getStatus() == self::STATUS_SEED_WAIT);
    }

    /**
     * {@inheritDoc}
     */
    public function getMapping()
    {
        return array(
            'id' => 'id',
            'name' => 'name',
            'status' => 'status',
            'isFinished' => 'finished',
            'uploadRate' => 'uploadRate',
            'downloadRate' => 'downloadRate',
            'files' => 'files',
            'peers' => 'peers',
            'trackers' => 'trackers'
        );
    }
}
