<?php
namespace Transmission;

use Transmission\Model\Torrent;
use Transmission\Transformer\ModelTransformer;
use Transmission\Transformer\TransformerInterface;
use Transmission\Exception\ErrorException;
use Transmission\Exception\InvalidResponseException;
use Transmission\Exception\TorrentNotFoundException;

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
     * @var Transmission\Transformer\TransformerInterface
     */
    protected $transformer;

    /**
     * @param string  $host
     * @param integer $port
     */
    public function __construct($host = null, $port = null)
    {
        $this->setClient(new Client($host, $port));
        $this->setTransformer(new ModelTransformer());
    }

    /**
     * @return array
     */
    public function getTorrents()
    {
        $response = $this->client->call('torrent-get', array(
            'fields' => array_values(Torrent::getMapping())
        ));

        $this->checkResponse($response);

        $torrents = array();

        foreach ($response->arguments->torrents as $torrent) {
            $t = $this->transformer->transform(new Torrent(), $torrent);

            $torrents[] = $t;
        }

        return $torrents;
    }

    /**
     * @return Transmission\Model\Torrent
     */
    public function getTorrent($id)
    {
        $response = $this->client->call('torrent-get', array(
            'fields' => array_values(Torrent::getMapping()),
            'ids' => array($id)
        ));

        $this->checkResponse($response);

        if (!count($response->arguments->torrents)) {
            throw new TorrentNotFoundException(sprintf(
                'There is no torrent with id %d', $id
            ));
        }

        return $this->transformer->transform(
            new Torrent(),
            $response->arguments->torrents[0]
        );
    }

    /**
     * @param string $uri
     *
     * @return Transmission\Model\Torrent
     */
    public function addTorrent($uri)
    {
        $response = $this->client->call('torrent-add', array(
            'filename' => $uri
        ));

        $this->checkResponse($response);

        $property = 'torrent-added';

        return $this->transformer->transform(
            new Torrent(),
            $response->arguments->$property
        );
    }

    /**
     * @param integer $id
     */
    public function removeTorrent($id)
    {
        $response = $this->client->call('torrent-remove', array(
            'ids' => array($id)
        ));

        $this->checkResponse($response);
    }

    /**
     * @param string $host
     */
    public function setHost($host)
    {
        $this->getClient()->setHost($host);
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->getClient()->getHost();
    }

    /**
     * @param integer $port
     */
    public function setPort($port)
    {
        $this->getClient()->setPort($port);
    }

    /**
     * @return integer
     */
    public function getPort()
    {
        return $this->getClient()->getPort();
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

    /**
     * @param stdClass $response
     *
     * @throws Transmission\Exception\ErrorException
     * @throws Transmission\Exception\InvalidResponseException
     */
    public function checkResponse($response)
    {
        if (!isset($response->arguments) || !isset($response->status)) {
            throw new InvalidResponseException(sprintf(
                'Received invalid response: "%s"',
                json_encode($response)
            ));
        }

        if ($response->status !== 'success') {
            throw new ErrorException(sprintf(
                'An error occured: "%s"', $response->status
            ));
        }
    }
}
