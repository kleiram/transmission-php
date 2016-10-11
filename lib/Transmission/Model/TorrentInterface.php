<?php
namespace Transmission\Model;

interface TorrentInterface
{
    /**
     * @param integer $id
     */
    public function setId($id);

    /**
     * @return integer
     */
    public function getId();

    /**
     * @param integer $eta
     */
    public function setEta($eta);

    /**
     * @return integer
     */
    public function getEta();

    /**
     * @param integer $size
     */
    public function setSize($size);

    /**
     * @return integer
     */
    public function getSize();

    /**
     * @param string $name
     */
    public function setName($name);

    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $hash
     */
    public function setHash($hash);

    /**
     * @return string
     */
    public function getHash();

    /**
     * @param integer|Status $status
     */
    public function setStatus($status);

    /**
     * @return integer
     */
    public function getStatus();

    /**
     * @param boolean $finished
     */
    public function setFinished($finished);

    /**
     * @return boolean
     */
    public function isFinished();

    /**
     * @var integer $startDate
     */
    public function setStartDate($startDate);

    /**
     * @return integer
     */
    public function getStartDate();

    /**
     * @var integer $rate
     */
    public function setUploadRate($rate);

    /**
     * @return integer
     */
    public function getUploadRate();

    /**
     * @param integer $rate
     */
    public function setDownloadRate($rate);

    /**
     * @param integer $peersConnected
     */
    public function setPeersConnected($peersConnected);

    /**
     * @return integer
     */
    public function getPeersConnected();

    /**
     * @return integer
     */
    public function getDownloadRate();

    /**
     * @param double $done
     */
    public function setPercentDone($done);

    /**
     * @return double
     */
    public function getPercentDone();

    /**
     * @param array $files
     */
    public function setFiles(array $files);

    /**
     * @return array
     */
    public function getFiles();

    /**
     * @param array $peers
     */
    public function setPeers(array $peers);

    /**
     * @return array
     */
    public function getPeers();

    /**
     * @param array $trackerStats
     */
    public function setTrackerStats(array $trackerStats);

    /**
     * @return array
     */
    public function getTrackerStats();

    /**
     * @param array $trackers
     */
    public function setTrackers(array $trackers);

    /**
     * @return array
     */
    public function getTrackers();

    /**
     * @param double $ratio
     */
    public function setUploadRatio($ratio);

    /**
     * @return double
     */
    public function getUploadRatio();

    /**
     * @return boolean
     */
    public function isStopped();

    /**
     * @return boolean
     */
    public function isChecking();

    /**
     * @return boolean
     */
    public function isDownloading();

    /**
     * @return boolean
     */
    public function isSeeding();
    
    /**
     * @return string
     */
    public function getDownloadDir();

    /**
     * @param string $downloadDir
     */
    public function setDownloadDir($downloadDir);

    /**
     * @return int
     */
    public function getDownloadedEver();

    /**
     * @param int $downloadedEver
     */
    public function setDownloadedEver($downloadedEver);

    /**
     * @return int
     */
    public function getUploadedEver();

    /**
     * @param int $uploadedEver
     */
    public function setUploadedEver($uploadedEver);
}
