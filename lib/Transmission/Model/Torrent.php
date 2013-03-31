<?php
namespace Transmission\Model;

/**
 * @author Ramon Kleiss <ramon@cubilon.nl>
 */
class Torrent implements ModelInterface
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var DateTime
     */
    protected $eta;

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
    protected $totalSize;

    /**
     * @var Boolean
     */
    protected $finished;

    /**
     * @var string
     */
    protected $error;

    /**
     * {@inheritDoc}
     */
    public static function getMapping()
    {
        return array(
            'id' => 'id',
            'name' => 'name',
            'eta' => 'eta',
            'downloadRate' => 'rateDownload',
            'uploadRate' => 'rateUpload',
            'totalSize' => 'totalSize',
            'finished' => 'isFinished',
            'error' => 'errorString'
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
     * @param integer $eta
     */
    public function setEta($eta)
    {
        if ($eta > 0) {
            $this->eta = date_create_from_format('U', $eta);
        }
        else {
            $this->eta = null;
        }
    }

    /**
     * @return DateTime
     */
    public function getEta()
    {
        return $this->eta;
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
     * @param integer $rate
     */
    public function setUploadRate($rate)
    {
        $this->uploadRate = (integer) $rate;
    }

    /**
     * @return integer
     */
    public function getUploadRate($rate)
    {
        return $this->uploadRate;
    }

    /**
     * @param integer $size
     */
    public function setTotalSize($size)
    {
        $this->totalSize = (integer) $totalSize;
    }

    /**
     * @return integer
     */
    public function getTotalSize()
    {
        return $this->totalSize;
    }

    /**
     * @param Boolean $finished
     */
    public function setFinished($finished)
    {
        $this->finished = (Boolean) $finished;
    }

    /**
     * @return Boolean
     */
    public function isFinished()
    {
        return $this->finished;
    }

    /**
     * @param string $error
     */
    public function setError($error)
    {
        $this->error = (string) $error;
    }

    /**
     * @return Boolean
     */
    public function hasError()
    {
        return !is_null($this->error);
    }

    /**
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }
}
