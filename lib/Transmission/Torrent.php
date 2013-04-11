<?php
namespace Transmission;

use Transmission\Exception\NoSuchTorrentException;
use Transmission\Exception\InvalidResponseException;

/**
 * The Torrent class represents a torrent in Transmissions download queue
 *
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
     * @var Transmission\Client
     */
    protected $client;

    /**
     * Constructor
     *
     * @param Transmission\Client $client
     */
    public function __construct(Client $client = null)
    {
        $this->setClient($client ?: new Client());
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
     * @param Transmission\Client $client
     */
    public function setClient(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @return Transmission\Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Remove the torrent from Transmissions download queue
     *
     * @param boolean $deleteLocalData
     */
    public function delete($deleteLocalData = false)
    {
        $arguments = array(
            'ids' => array($this->getId()),
            'delete-local-data' => $deleteLocalData
        );

        $response = $this->getClient()->call('torrent-remove', $arguments);

        if (!isset($response->result)) {
            throw new InvalidResponseException(
                'Invalid response received from Transmission'
            );
        }

        if ($response->result !== 'success') {
            throw new \RuntimeException($response->result);
        }
    }

    /**
     * Get all the torrents in the download queue
     *
     * @param Transmission\Client $client
     * @return array
     * @throws RuntimeException
     * @throws Transmission\Exception\InvalidResponseException
     */
    public static function all(Client $client = null)
    {
        $client = $client ?: new Client();

        $arguments = array(
            'fields' => array_keys(self::getMapping()),
            'ids' => array()
        );

        $response = $client->call('torrent-get', $arguments);

        if (!isset($response->result)) {
            throw new InvalidResponseException(
                'Invalid response received from Transmission'
            );
        }

        if ($response->result !== 'success') {
            throw new \RuntimeException($response->result);
        }

        if (!isset($response->arguments) ||
            !isset($response->arguments->torrents)) {
            throw new InvalidResponseException(
                'Invalid response received from Transmission'
            );
        }

        $torrents = array();

        foreach ($response->arguments->torrents as $torrent) {
            $torrents[] = ResponseTransformer::transform(
                $torrent,
                new Torrent($client),
                self::getMapping()
            );
        }

        return $torrents;
    }

    /**
     * Get a torrents info
     *
     * @param integer $id
     * @param Transmission\Client $client
     * @return Transmission\Torrent
     * @throws RuntimeException
     * @throws Transmission\Exception\NoSuchTorrentException
     * @throws Transmission\Exception\InvalidResponseException
     */
    public static function get($id, Client $client = null)
    {
        $client = $client ?: new Client();

        $arguments = array(
            'fields' => array_keys(self::getMapping()),
            'ids' => array($id)
        );

        $response = $client->call('torrent-get', $arguments);

        if (!isset($response->result)) {
            throw new InvalidResponseException(
                'Invalid response received from Transmission'
            );
        }

        if ($response->result !== 'success') {
            throw new \RuntimeException($response->result);
        }

        if (!isset($response->arguments) ||
            !isset($response->arguments->torrents)) {
            throw new InvalidResponseException(
                'Invalid response received from Transmission'
            );
        }

        if (count($response->arguments->torrents) == 0) {
            throw new NoSuchTorrentException(sprintf(
                'Torrent with ID %d not found', $id
            ));
        }

        return ResponseTransformer::transform(
            $response->arguments->torrents[0],
            new Torrent($client),
            self::getMapping()
        );
    }

    /**
     * Add a torrent to Transmissions download queue
     *
     * @param string              $torrent
     * @param Transmission\Client $client
     * @param boolean             $meta
     * @return Transmission\Torrent
     * @throws RuntimeException
     * @throws Transmission\Exception\InvalidResponseException
     */
    public static function add($torrent, Client $client = null, $meta = false)
    {
        $client = $client ?: new Client();

        $arguments[!$meta ? 'torrent' : 'metainfo'] = $torrent;

        $response     = $client->call('torrent-add', $arguments);
        $torrentField = 'torrent-added';

        if (!isset($response->result)) {
            throw new InvalidResponseException(
                'Invalid response received from Transmission'
            );
        }

        if ($response->result !== 'success') {
            throw new \RuntimeException($response->result);
        }

        if (!isset($response->arguments) ||
            !isset($response->arguments->$torrentField) ||
            empty($response->arguments->$torrentField)) {
            throw new InvalidResponseException(
                'Invalid response received from Transmission'
            );
        }

        return ResponseTransformer::transform(
            $response->arguments->$torrentField,
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
