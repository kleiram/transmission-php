<?php
namespace Transmission\Model;

use Transmission\Util\PropertyMapper;
use Transmission\Util\ResponseValidator;

class Session extends AbstractModel
{
    protected $altSpeedDown;
    protected $altSpeedEnabled;
    protected $downloadDir;
    protected $downloadQueueEnabled;
    protected $downloadQueueSize;
    protected $incompleteDir;
    protected $incompleteDirEnabled;
    protected $scriptTorrentDoneFilename;
    protected $scriptTorrentDoneEnabled;
    protected $seedRatioLimit;
    protected $seedRatioLimited;
    protected $seedQueueSize;
    protected $seedQueueEnabled;
    protected $speedLimitDown;
    protected $speedLimitDownEnabled;

    /**
     * Gets the value of altSpeedDown.
     *
     * @return mixed
     */
    public function getAltSpeedDown()
    {
        return $this->altSpeedDown;
    }

    /**
     * Sets the value of altSpeedDown.
     *
     * @param mixed $altSpeedDown the altSpeedDown
     *
     * @return self
     */
    public function setAltSpeedDown($altSpeedDown)
    {
        $this->altSpeedDown = $altSpeedDown;

        return $this;
    }

    /**
     * Gets the value of altSpeedEnabled.
     *
     * @return mixed
     */
    public function getAltSpeedEnabled()
    {
        return $this->altSpeedEnabled;
    }

    /**
     * Sets the value of altSpeedEnabled.
     *
     * @param mixed $altSpeedEnabled the altSpeedEnabled
     *
     * @return self
     */
    public function setAltSpeedEnabled($altSpeedEnabled)
    {
        $this->altSpeedEnabled = $altSpeedEnabled;

        return $this;
    }

    /**
     * Gets the value of downloadDir.
     *
     * @return mixed
     */
    public function getDownloadDir()
    {
        return $this->downloadDir;
    }

    /**
     * Sets the value of downloadDir.
     *
     * @param mixed $downloadDir the downloadDir
     *
     * @return self
     */
    public function setDownloadDir($downloadDir)
    {
        $this->downloadDir = $downloadDir;

        return $this;
    }

    /**
     * Gets the value of downloadQueueEnabled.
     *
     * @return mixed
     */
    public function getDownloadQueueEnabled()
    {
        return $this->downloadQueueEnabled;
    }

    /**
     * Sets the value of downloadQueueEnabled.
     *
     * @param mixed $downloadQueueEnabled the downloadQueueEnabled
     *
     * @return self
     */
    public function setDownloadQueueEnabled($downloadQueueEnabled)
    {
        $this->downloadQueueEnabled = $downloadQueueEnabled;

        return $this;
    }

    /**
     * Gets the value of downloadQueueSize.
     *
     * @return mixed
     */
    public function getDownloadQueueSize()
    {
        return $this->downloadQueueSize;
    }

    /**
     * Sets the value of downloadQueueSize.
     *
     * @param mixed $downloadQueueSize the downloadQueueSize
     *
     * @return self
     */
    public function setDownloadQueueSize($downloadQueueSize)
    {
        $this->downloadQueueSize = $downloadQueueSize;

        return $this;
    }

    /**
     * Gets the value of incompleteDir.
     *
     * @return mixed
     */
    public function getIncompleteDir()
    {
        return $this->incompleteDir;
    }

    /**
     * Sets the value of incompleteDir.
     *
     * @param mixed $incompleteDir the incompleteDir
     *
     * @return self
     */
    public function setIncompleteDir($incompleteDir)
    {
        $this->incompleteDir = $incompleteDir;

        return $this;
    }

    /**
     * Gets the value of incompleteDirEnabled.
     *
     * @return mixed
     */
    public function getIncompleteDirEnabled()
    {
        return $this->incompleteDirEnabled;
    }

    /**
     * Sets the value of incompleteDirEnabled.
     *
     * @param mixed $incompleteDirEnabled the incompleteDirEnabled
     *
     * @return self
     */
    public function setIncompleteDirEnabled($incompleteDirEnabled)
    {
        $this->incompleteDirEnabled = $incompleteDirEnabled;

        return $this;
    }

    /**
     * Gets the value of scriptTorrentDoneFilename.
     *
     * @return mixed
     */
    public function getScriptTorrentDoneFilename()
    {
        return $this->scriptTorrentDoneFilename;
    }

    /**
     * Sets the value of scriptTorrentDoneFilename.
     *
     * @param mixed $scriptTorrentDoneFilename the scriptTorrentDoneFilename
     *
     * @return self
     */
    public function setScriptTorrentDoneFilename($scriptTorrentDoneFilename)
    {
        $this->scriptTorrentDoneFilename = $scriptTorrentDoneFilename;

        return $this;
    }

    /**
     * Gets the value of scriptTorrentDoneEnabled.
     *
     * @return mixed
     */
    public function getScriptTorrentDoneEnabled()
    {
        return $this->scriptTorrentDoneEnabled;
    }

    /**
     * Sets the value of scriptTorrentDoneEnabled.
     *
     * @param mixed $scriptTorrentDoneEnabled the scriptTorrentDoneEnabled
     *
     * @return self
     */
    public function setScriptTorrentDoneEnabled($scriptTorrentDoneEnabled)
    {
        $this->scriptTorrentDoneEnabled = $scriptTorrentDoneEnabled;

        return $this;
    }

    /**
     * Gets the value of seedRatioLimit.
     *
     * @return mixed
     */
    public function getSeedRatioLimit()
    {
        return $this->seedRatioLimit;
    }

    /**
     * Sets the value of seedRatioLimit.
     *
     * @param mixed $seedRatioLimit the seedRatioLimit
     *
     * @return self
     */
    public function setSeedRatioLimit($seedRatioLimit)
    {
        $this->seedRatioLimit = $seedRatioLimit;

        return $this;
    }

    /**
     * Gets the value of seedRatioLimited.
     *
     * @return mixed
     */
    public function getSeedRatioLimited()
    {
        return $this->seedRatioLimited;
    }

    /**
     * Sets the value of seedRatioLimited.
     *
     * @param mixed $seedRatioLimited the seedRatioLimited
     *
     * @return self
     */
    public function setSeedRatioLimited($seedRatioLimited)
    {
        $this->seedRatioLimited = $seedRatioLimited;

        return $this;
    }

    /**
     * Gets the value of seedQueueSize.
     *
     * @return mixed
     */
    public function getSeedQueueSize()
    {
        return $this->seedQueueSize;
    }

    /**
     * Sets the value of seedQueueSize.
     *
     * @param mixed $seedQueueSize the seedQueueSize
     *
     * @return self
     */
    public function setSeedQueueSize($seedQueueSize)
    {
        $this->seedQueueSize = $seedQueueSize;

        return $this;
    }

    /**
     * Gets the value of seedQueueEnabled.
     *
     * @return mixed
     */
    public function getSeedQueueEnabled()
    {
        return $this->seedQueueEnabled;
    }

    /**
     * Sets the value of seedQueueEnabled.
     *
     * @param mixed $seedQueueEnabled the seedQueueEnabled
     *
     * @return self
     */
    public function setSeedQueueEnabled($seedQueueEnabled)
    {
        $this->seedQueueEnabled = $seedQueueEnabled;

        return $this;
    }

    /**
     * Gets the value of speedLimitDown.
     *
     * @return mixed
     */
    public function getSpeedLimitDown()
    {
        return $this->speedLimitDown;
    }

    /**
     * Sets the value of speedLimitDown.
     *
     * @param mixed $speedLimitDown the speedLimitDown
     *
     * @return self
     */
    public function setSpeedLimitDown($speedLimitDown)
    {
        $this->speedLimitDown = $speedLimitDown;

        return $this;
    }

    /**
     * Gets the value of speedLimitDownEnabled.
     *
     * @return mixed
     */
    public function getSpeedLimitDownEnabled()
    {
        return $this->speedLimitDownEnabled;
    }

    /**
     * Sets the value of speedLimitDownEnabled.
     *
     * @param mixed $speedLimitDownEnabled the speedLimitDownEnabled
     *
     * @return self
     */
    public function setSpeedLimitDownEnabled($speedLimitDownEnabled)
    {
        $this->speedLimitDownEnabled = $speedLimitDownEnabled;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public static function getMapping()
    {
        return array(
        	'alt-speed-down'=>'altSpeedDown',
        	'alt-speed-enabled'=>'altSpeedEnabled',
        	'download-dir'=>'downloadDir',
        	'download-queue-enabled'=>'downloadQueueEnabled',
        	'download-queue-size'=>'downloadQueueSize',
        	'incomplete-dir'=>'incompleteDir',
        	'incomplete-dir-enabled'=>'incompleteDirEnabled',
        	'script-torrent-done-filename'=>'scriptTorrentDoneFilename',
        	'script-torrent-done-enabled'=>'scriptTorrentDoneEnabled',
        	'seedRatioLimit'=>'seedRatioLimit',
        	'seedRatioLimited'=>'seedRatioLimited',
        	'seed-queue-size'=>'seedQueueSize',
        	'seed-queue-enabled'=>'seedQueueEnabled',
        	'speed-limit-down'=>'speedLimitDown',
        	'speed-limit-down-enabled'=>'speedLimitDownEnabled',

        );
    }

    /**
     * @param string $method
     * @param array  $arguments
     */
    protected function call($method, $arguments)
    {
        if (!($client = $this->getClient())) {
            return;
        }

        ResponseValidator::validate(
            $method,
            $client->call($method, $arguments)
        );
    }

    public function save(){
    	$arguments=array();
    	$method='session-set';
    	foreach (self::getMapping() as $key => $value) {
    		$arguments[$key]=$this->$value;
    	}
    	if (!($client = $this->getClient())) {
            return;
        }

        ResponseValidator::validate(
            $method,
            $client->call($method, $arguments)
        );
    }
}