<?php

namespace Transmission\Model\Stats;

use Transmission\Model\ModelInterface;

class Stats implements ModelInterface{

    protected $downloadedBytes;
    protected $filesAdded;
    protected $secondsActive;
    protected $sessionCount;
    protected $uploadedBytes;

    /**
     * Gets the value of downloadedBytes.
     *
     * @return mixed
     */
    public function getDownloadedBytes()
    {
        return $this->downloadedBytes;
    }
    
    /**
     * Sets the value of downloadedBytes.
     *
     * @param mixed $downloadedBytes the downloaded bytes
     *
     * @return self
     */
    public function setDownloadedBytes($downloadedBytes)
    {
        $this->downloadedBytes = $downloadedBytes;

        return $this;
    }

    /**
     * Gets the value of filesAdded.
     *
     * @return mixed
     */
    public function getFilesAdded()
    {
        return $this->filesAdded;
    }
    
    /**
     * Sets the value of filesAdded.
     *
     * @param mixed $filesAdded the files added
     *
     * @return self
     */
    public function setFilesAdded($filesAdded)
    {
        $this->filesAdded = $filesAdded;

        return $this;
    }

    /**
     * Gets the value of secondsActive.
     *
     * @return mixed
     */
    public function getSecondsActive()
    {
        return $this->secondsActive;
    }
    
    /**
     * Sets the value of secondsActive.
     *
     * @param mixed $secondsActive the seconds active
     *
     * @return self
     */
    public function setSecondsActive($secondsActive)
    {
        $this->secondsActive = $secondsActive;

        return $this;
    }

    /**
     * Gets the value of sessionCount.
     *
     * @return mixed
     */
    public function getSessionCount()
    {
        return $this->sessionCount;
    }
    
    /**
     * Sets the value of sessionCount.
     *
     * @param mixed $sessionCount the session count
     *
     * @return self
     */
    public function setSessionCount($sessionCount)
    {
        $this->sessionCount = $sessionCount;

        return $this;
    }

    /**
     * Gets the value of uploadedBytes.
     *
     * @return mixed
     */
    public function getUploadedBytes()
    {
        return $this->uploadedBytes;
    }
    
    /**
     * Sets the value of uploadedBytes.
     *
     * @param mixed $uploadedBytes the uploaded bytes
     *
     * @return self
     */
    public function setUploadedBytes($uploadedBytes)
    {
        $this->uploadedBytes = $uploadedBytes;

        return $this;
    }

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
