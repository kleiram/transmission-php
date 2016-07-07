<?php
namespace Transmission;

use Transmission\Model\Torrent;
use Transmission\Model\Session;
use Transmission\Model\FreeSpace;
use Transmission\Model\Stats\Session as SessionStats;
use Transmission\Util\PropertyMapper;
use Transmission\Util\ResponseValidator;

/**
 * @author Ramon Kleiss <ramon@cubilon.nl>
 */
class Transmission
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var ResponseValidator
     */
    protected $validator;

    /**
     * @var PropertyMapper
     */
    protected $mapper;

    /**
     * Constructor
     *
     * @param string  $host
     * @param integer $port
     * @param string  $path
     */
    public function __construct($host = null, $port = null, $path = null)
    {
        $this->setClient(new Client($host, $port, $path));
        $this->setMapper(new PropertyMapper());
        $this->setValidator(new ResponseValidator());
    }

    /**
     * Get all the torrents in the download queue
     *
     * @return Torrent[]
     */
    public function all()
    {
        $client   = $this->getClient();
        $mapper   = $this->getMapper();
        $response = $this->getClient()->call(
            'torrent-get',
            array('fields' => array_keys(Torrent::getMapping()))
        );

        $torrents = array_map(function ($data) use ($mapper, $client) {
            return $mapper->map(
                new Torrent($client),
                $data
            );
        }, $this->getValidator()->validate('torrent-get', $response));

        return $torrents;
    }

    /**
     * Get a specific torrent from the download queue
     *
     * @param  integer                    $id
     * @return Torrent
     * @throws \RuntimeException
     */
    public function get($id)
    {
        $client   = $this->getClient();
        $mapper   = $this->getMapper();
        $response = $this->getClient()->call('torrent-get', array(
            'fields' => array_keys(Torrent::getMapping()),
            'ids'    => array($id)
        ));

        $torrent = array_reduce(
            $this->getValidator()->validate('torrent-get', $response),
            function ($torrent, $data) use ($mapper, $client) {
                return $torrent ? $torrent : $mapper->map(new Torrent($client), $data);
            });

        if (!$torrent instanceof Torrent) {
            throw new \RuntimeException(sprintf("Torrent with ID %s not found", $id));
        }

        return $torrent;
    }

    /**
     * Get the Transmission session
     *
     * @return Session
     */
    public function getSession()
    {
        $response = $this->getClient()->call(
            'session-get',
            array()
        );

        return $this->getMapper()->map(
            new Session($this->getClient()),
            $this->getValidator()->validate('session-get', $response)
        );
    }

    /**
     * @return SessionStats
     */
    public function getSessionStats()
    {
        $response = $this->getClient()->call(
            'session-stats',
            array()
        );

        return $this->getMapper()->map(
            new SessionStats(),
            $this->getValidator()->validate('session-stats', $response)
        );
    }

    /**
     * Get Free space
     * @param  string $path
     * @return FreeSpace
     */
    public function getFreeSpace($path=null)
    {
        if (!$path) {
            $path = $this->getSession()->getDownloadDir();
        }
        $response = $this->getClient()->call(
            'free-space',
            array('path'=>$path)
        );

        return $this->getMapper()->map(
            new FreeSpace(),
            $this->getValidator()->validate('free-space', $response)
        );
    }

    /**
     * Add a torrent to the download queue
     *
     * @param  string   $torrent
     * @param  boolean  $metainfo
     * @param  string   $savepath
     * @return Torrent
     */
    public function add($torrent, $metainfo = false, $savepath = null)
    {
        $parameters = array($metainfo ? 'metainfo' : 'filename' => $torrent);

        if ($savepath !== null) {
            $parameters['download-dir'] = (string) $savepath;
        }

        $response = $this->getClient()->call(
            'torrent-add',
            $parameters
        );

        return $this->getMapper()->map(
            new Torrent($this->getClient()),
            $this->getValidator()->validate('torrent-add', $response)
        );
    }

    /**
     * Start the download of a torrent
     *
     * @param Torrent $torrent
     * @param bool    $now
     */
    public function start(Torrent $torrent, $now = false)
    {
        $this->getClient()->call(
            $now ? 'torrent-start-now' : 'torrent-start',
            array('ids' => array($torrent->getId()))
        );
    }

    /**
     * Stop the download of a torrent
     *
     * @param Torrent $torrent
     */
    public function stop(Torrent $torrent)
    {
        $this->getClient()->call(
            'torrent-stop',
            array('ids' => array($torrent->getId()))
        );
    }

    /**
     * Verify the download of a torrent
     *
     * @param Torrent $torrent
     */
    public function verify(Torrent $torrent)
    {
        $this->getClient()->call(
            'torrent-verify',
            array('ids' => array($torrent->getId()))
        );
    }

    /**
     * Request a reannounce of a torrent
     *
     * @param Torrent $torrent
     */
    public function reannounce(Torrent $torrent)
    {
        $this->getClient()->call(
            'torrent-reannounce',
            array('ids' => array($torrent->getId()))
        );
    }

    /**
     * Remove a torrent from the download queue
     *
     * @param Torrent $torrent
     */
    public function remove(Torrent $torrent, $localData = false)
    {
        $arguments = array('ids' => array($torrent->getId()));

        if ($localData) {
            $arguments['delete-local-data'] = true;
        }

        $this->getClient()->call('torrent-remove', $arguments);
    }

    /**
     * Set the client used to connect to Transmission
     *
     * @param Client $client
     */
    public function setClient(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Get the client used to connect to Transmission
     *
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Set the hostname of the Transmission server
     *
     * @param string $host
     */
    public function setHost($host)
    {
        $this->getClient()->setHost($host);
    }

    /**
     * Get the hostname of the Transmission server
     *
     * @return string
     */
    public function getHost()
    {
        return $this->getClient()->getHost();
    }

    /**
     * Set the port the Transmission server is listening on
     *
     * @param integer $port
     */
    public function setPort($port)
    {
        $this->getClient()->setPort($port);
    }

    /**
     * Get the port the Transmission server is listening on
     *
     * @return integer
     */
    public function getPort()
    {
        return $this->getClient()->getPort();
    }

    /**
     * Set the mapper used to map responses from Transmission to models
     *
     * @param PropertyMapper $mapper
     */
    public function setMapper(PropertyMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    /**
     * Get the mapper used to map responses from Transmission to models
     *
     * @return PropertyMapper
     */
    public function getMapper()
    {
        return $this->mapper;
    }

    /**
     * Set the validator used to validate Transmission responses
     *
     * @param ResponseValidator $validator
     */
    public function setValidator(ResponseValidator $validator)
    {
        $this->validator = $validator;
    }

    /**
     * Get the validator used to validate Transmission responses
     *
     * @return ResponseValidator
     */
    public function getValidator()
    {
        return $this->validator;
    }
}
