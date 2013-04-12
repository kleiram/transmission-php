<?php
namespace Transmission;

use Transmission\Model\Tracker;
use Transmission\Exception\NoSuchTorrentException;
use Transmission\Exception\InvalidResponseException;

/**
 * The Torrent class represents a torrent in Transmissions download queue
 *
 * @author Ramon Kleiss <ramon@cubilon.nl>
 */
class Torrent extends BaseTorrent
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
    protected $trackers;

    /**
     * Constructor
     *
     * @param Transmission\Client $client
     */
    public function __construct(Client $client = null)
    {
        parent::__construct($client);

        $this->trackers = array();
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
     * @param Transmission\Tracker $tracker
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
     * Remove the torrent from Transmissions download queue
     *
     * @param boolean $deleteLocalData
     */
    public function delete($deleteLocalData = false)
    {
        parent::_delete($this->getId(), $deleteLocalData);
    }

    /**
     * Get all the torrents in the download queue
     *
     * @param Transmission\Client $client
     * @return array
     */
    public static function all(Client $client = null)
    {
        $torrents = parent::_all($client, array_keys(self::getMapping()));
        $result   = array();

        foreach ($torrents as $torrent) {
            $t = ResponseTransformer::transform(
                $torrent,
                new Torrent($client),
                self::getMapping()
            );

            if (isset($torrent->trackers)) {
                foreach ($torrent->trackers as $tracker) {
                    $t->addTracker(ResponseTransformer::transform(
                        $tracker,
                        new Tracker(),
                        Tracker::getMapping()
                    ));
                }
            }

            $result[] = $t;
        }

        return $result;
    }

    /**
     * Get a torrents info
     *
     * @param integer $id
     * @param Transmission\Client $client
     * @return Transmission\Torrent
     */
    public static function get($id, Client $client = null)
    {
        $torrent = parent::_get($id, $client, array_keys(self::getMapping()));

        $t = ResponseTransformer::transform(
            $torrent,
            new Torrent($client),
            self::getMapping()
        );

        if (isset($torrent->trackers)) {
            foreach ($torrent->trackers as $tracker) {
                $t->addTracker(ResponseTransformer::transform(
                    $tracker,
                    new Tracker(),
                    Tracker::getMapping()
                ));
            }
        }

        return $t;
    }

    /**
     * Add a torrent to Transmissions download queue
     *
     * @param string              $torrent
     * @param Transmission\Client $client
     * @param boolean             $meta
     */
    public static function add($torrent, Client $client = null, $meta = false)
    {
        $torrent = parent::_add($torrent, $client, $meta);

        return ResponseTransformer::transform(
            $torrent,
            new Torrent($client),
            self::getMapping()
        );
    }

    /**
     * @return array
     */
    protected static function getMapping()
    {
        return array(
            'id' => 'id',
            'name' => 'name'
        );
    }
}
