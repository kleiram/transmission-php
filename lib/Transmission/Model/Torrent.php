<?php
namespace Transmission\Model;

/**
 * @author Ramon Kleiss <ramon@cubilon.nl>
 */
class Torrent
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
     * @var integer
     */
    protected $size;

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
}
