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
     * @var string
     */
    protected $name;

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
     * {@inheritDoc}
     */
    public function getMapping()
    {
        return array(
            'id' => 'id',
            'name' => 'name',
            'files' => 'files',
            'peers' => 'peers',
            'trackers' => 'trackers'
        );
    }
}
