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
     * @var double
     */
    protected $uploadRatio;
    
    /**
	 * @var string
	 */
	protected $downloadDir;

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
     * @param string $hash
     */
    public function setHash($hash)
    {
        $this->hash = (string) $hash;
    }

    /**
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * @param integer|Transmission\Model\Status $status
     */
    public function setStatus($status)
    {
        $this->status = new Status($status);
    }

    /**
     * @return integer
     */
    public function getStatus()
    {
        return $this->status->getValue();
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
        return ($this->finished || (int) $this->getPercentDone() == 100);
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
     * @param double $done
     */
    public function setPercentDone($done)
    {
        $this->percentDone = (double) $done;
    }

    /**
     * @return double
     */
    public function getPercentDone()
    {
        return $this->percentDone * 100.0;
    }

    /**
     * @param array $files
     */
    public function setFiles(array $files)
    {
        $this->files = array_map(function ($file) {
            return PropertyMapper::map(new File(), $file);
        }, $files);
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
        $this->peers = array_map(function ($peer) {
            return PropertyMapper::map(new Peer(), $peer);
        }, $peers);
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
        $this->trackers = array_map(function ($tracker) {
            return PropertyMapper::map(new Tracker(), $tracker);
        }, $trackers);
    }

    /**
     * @return array
     */
    public function getTrackers()
    {
        return $this->trackers;
    }

    /**
     * @param double $ratio
     */
    public function setUploadRatio($ratio)
    {
        $this->uploadRatio = (double) $ratio;
    }

    /**
     * @return double
     */
    public function getUploadRatio()
    {
        return $this->uploadRatio;
    }

    /**
     * @return boolean
     */
    public function isStopped()
    {
        return $this->status->isStopped();
    }

    /**
     * @return boolean
     */
    public function isChecking()
    {
        return $this->status->isChecking();
    }

    /**
     * @return boolean
     */
    public function isDownloading()
    {
        return $this->status->isDownloading();
    }

    /**
     * @return boolean
     */
    public function isSeeding()
    {
        return $this->status->isSeeding();
    }
    
    /**
	 * @return string
	 */
	public function getDownloadDir()
	{
		return $this->downloadDir;
	}

	/**
	 * @param string $downloadDir
	 */
	public function setDownloadDir($downloadDir)
	{
		$this->downloadDir = $downloadDir;
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
            'trackers' => 'trackers',
            'uploadRatio' => 'uploadRatio',
            'hashString' => 'hash',
            'downloadDir' => 'downloadDir'
        );
    }
}
