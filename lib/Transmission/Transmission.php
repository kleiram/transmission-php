<?php
namespace Transmission;

use Transmission\Model\Torrent;
use Transmission\Util\PropertyMapper;
use Transmission\Util\ResponseValidator;

/**
 * @author Ramon Kleiss <ramon@cubilon.nl>
 */
class Transmission
{
    /**
     * @var Transmission\Client
     */
    protected $client;

    /**
     * @var Transmission\Util\ResponseValidator
     */
    protected $validator;

    /**
     * @var Transmission\Util\PropertyMapper
     */
    protected $mapper;

    /**
     * Constructor
     *
     * @param string  $host
     * @param integer $port
     */
    public function __construct($host = null, $port = null)
    {
        $this->setClient(new Client($host, $port));
        $this->setMapper(new PropertyMapper());
        $this->setValidator(new ResponseValidator());
    }

    /**
     * @return array
     */
    public function all()
    {
        $response = $this->getClient()->call(
            'torrent-get',
            array('fields' => array_keys(Torrent::getMapping()))
        );

        $torrents = array();

        foreach ($this->getValidator()->validate('torrent-get', $response) as $t) {
            $torrents[] = $this->getMapper()->map(
                new Torrent($this->getClient()),
                $t
            );
        }

        return $torrents;
    }

    /**
     * @param integer $id
     * @return Transmission\Model\Torrent
     */
    public function get($id)
    {
        $response = $this->getClient()->call(
            'torrent-get',
            array(
                'fields' => array_keys(Torrent::getMapping()),
                'ids'    => array($id)
            )
        );

        $torrent = null;

        foreach ($this->getValidator()->validate('torrent-get', $response) as $t) {
            $torrent = $this->getMapper()->map(
                new Torrent($this->getClient()),
                $t
            );
        }

        if (!$torrent instanceof Torrent) {
            throw new \RuntimeException(
                sprintf("Torrent with ID %d not found", $id)
            );
        }

        return $torrent;
    }

    /**
     * @param string  $filename
     * @param boolean $metainfo
     * @return Transmission\Model\Torrent
     */
    public function add($torrent, $metainfo = false)
    {
        $response = $this->getClient()->call(
            'torrent-add',
            array($metainfo ? 'metainfo' : 'filename' => $torrent)
        );

        return $this->getMapper()->map(
            new Torrent($this->getClient()),
            $this->getValidator()->validate('torrent-add', $response)
        );
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
     * @param Transmission\Util\PropertyMapper $mapper
     */
    public function setMapper(PropertyMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    /**
     * @return Transmission\Util\PropertyMapper
     */
    public function getMapper()
    {
        return $this->mapper;
    }

    /**
     * @param Transmission\Util\ResponseValidator $validator
     */
    public function setValidator(ResponseValidator $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @return Transmission\Util\ResponseValidator
     */
    public function getValidator()
    {
        return $this->validator;
    }
}
