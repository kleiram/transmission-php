<?php

namespace Transmission\Model\Stats;

use Transmission\Model\ModelInterface;

/**
 * @author Joysen Chellem
 */
class Stats implements ModelInterface
{
    /**
     * @var integer
     */
    protected $downloadedBytes;

    /**
     * @var integer
     */
    protected $filesAdded;

    /**
     * @var integer
     */
    protected $secondsActive;

    /**
     * @var integer
     */
    protected $sessionCount;

    /**
     * @var integer
     */
    protected $uploadedBytes;

    /**
     * Gets the value of downloadedBytes.
     *
     * @return integer
     */
    public function getDownloadedBytes()
    {
        return $this->downloadedBytes;
    }

    /**
     * Sets the value of downloadedBytes.
     *
     * @param integer $downloadedBytes the downloaded bytes
     */
    public function setDownloadedBytes($downloadedBytes)
    {
        $this->downloadedBytes = $downloadedBytes;
    }

    /**
     * Gets the value of filesAdded.
     *
     * @return integer
     */
    public function getFilesAdded()
    {
        return $this->filesAdded;
    }

    /**
     * Sets the value of filesAdded.
     *
     * @param integer $filesAdded the files added
     */
    public function setFilesAdded($filesAdded)
    {
        $this->filesAdded = $filesAdded;
    }

    /**
     * Gets the value of secondsActive.
     *
     * @return integer
     */
    public function getSecondsActive()
    {
        return $this->secondsActive;
    }

    /**
     * Sets the value of secondsActive.
     *
     * @param integer $secondsActive the seconds active
     */
    public function setSecondsActive($secondsActive)
    {
        $this->secondsActive = $secondsActive;
    }

    /**
     * Gets the value of sessionCount.
     *
     * @return integer
     */
    public function getSessionCount()
    {
        return $this->sessionCount;
    }

    /**
     * Sets the value of sessionCount.
     *
     * @param integer $sessionCount the session count
     */
    public function setSessionCount($sessionCount)
    {
        $this->sessionCount = $sessionCount;
    }

    /**
     * Gets the value of uploadedBytes.
     *
     * @return integer
     */
    public function getUploadedBytes()
    {
        return $this->uploadedBytes;
    }

    /**
     * Sets the value of uploadedBytes.
     *
     * @param integer $uploadedBytes the uploaded bytes
     */
    public function setUploadedBytes($uploadedBytes)
    {
        $this->uploadedBytes = $uploadedBytes;
    }

    /**
     * {@inheritDoc}
     */
    public static function getMapping()
    {
        return array(
            'downloadedBytes' => 'downloadedBytes',
            'filesAdded' => 'filesAdded',
            'secondsActive' => 'secondsActive',
            'sessionCount' => 'sessionCount',
            'uploadedBytes' => 'uploadedBytes'
        );
    }
}
