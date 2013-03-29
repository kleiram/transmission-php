<?php
namespace Transmission;

use Transmission\Model\Torrent;

use Transmission\Exception\NoSuchTorrentException;
use Transmission\Transformer\ModelTransformer;
use Transmission\Transformer\TransformerInterface;

/**
 * @author Ramon Kleiss <ramon@cubilon.nl>
 */
class Service
{
    /**
     * @var Transmission\Client
     */
    protected $client;

    /**
     * @var Transmission\Transformer\TransformerInterface
     */
    protected $transformer;

    /**
     * Constructor
     *
     * @param string  $host
     * @param integer $port
     */
    public function __construct($host = null, $port = null)
    {
        $this->setClient(new Client($host, $port));
        $this->setTransformer(new ModelTransformer());
    }

    /**
     * @param integer $id
     *
     * @return mixed
     */
    public function get($id = null)
    {
        if (is_null($id)) {
            return $this->getTorrents();
        }

        return $this->getTorrent($id);
    }

    /**
     * @param string $filename
     *
     * @return Transmission\Model\Torrent
     */
    public function add($filename)
    {
        return $this->addTorrent($filename);
    }

    /**
     * @param integer $id
     */
    public function remove($id)
    {
        $this->removeTorrent($id);
    }

    /**
     * @return array
     */
    public function getTorrents()
    {
        $t = new Torrent();

        $response = $this->getClient()->call(json_encode(
            array(
                'arguments' => array(
                    'fields' => array_merge(
                        array_values($t->getFieldMap()),
                        array('files', 'trackers', 'peers')
                    ),
                ),
                'method' => 'torrent-get'
            )
        ));

        return $this->getTransformer()->transform($response);
    }

    /**
     * @param integer $id
     *
     * @return Transmission\Model\Torrent
     */
    public function getTorrent($id)
    {
        $t = new Torrent();

        $response = $this->getClient()->call(json_encode(
            array(
                'arguments' => array(
                    'fields' => array_merge(
                        array_values($t->getFieldMap()),
                        array('files', 'trackers', 'peers')
                    ),
                    'ids' => array($id),
                    'method' => 'torrent-get'
                )
            )
        ));

        $torrents = $this->getTransformer()->transform($response);

        if (!count($torrents)) {
            throw new NoSuchTorrentException(sprintf(
                'Torrent with id %d doesn\'t exist', $id
            ));
        }

        return $torrents[0];
    }

    /**
     * @param string $filename
     *
     * @return Transmission\Model\Torrent
     */
    public function addTorrent($filename)
    {
        $response = $this->getClient()->call(json_encode(
            array(
                'arguments' => array(
                    'filename' => (string) $filename,
                ),
                'method' => 'torrent-add'
            )
        ));

        return $this->getTransformer()->transform($response);
    }

    /**
     * @param integer $id
     * @param Boolean $deleteLocal
     */
    public function removeTorrent($id, $deleteLocal = false)
    {
        $response = $this->getClient()->call(json_encode(
            array(
                'arguments' => array(
                    'ids' => array($id),
                    'deleteLocal' => $deleteLocal
                ),
                'method' => 'torrent-remove'
            )
        ));

        $this->getTransformer()->transform($response);
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
     * @param Transmission\Transformer\TransformerInterface $transformer
     */
    public function setTransformer(TransformerInterface $transformer)
    {
        $this->transformer = $transformer;
    }

    /**
     * @return Transmission\Transformer\TransformerInterface
     */
    public function getTransformer()
    {
        return $this->transformer;
    }
}
