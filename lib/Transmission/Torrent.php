<?php
namespace Transmission;

use Transmission\Exception\NoSuchTorrentException;
use Transmission\Exception\InvalidResponseException;

class Torrent
{
    protected $id;
    protected $name;
    protected $client;

    public function __construct(Client $client = null)
    {
        $this->setClient($client ?: new Client());
    }

    public function setId($id)
    {
        $this->id = (integer) $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = (string) $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setClient(Client $client)
    {
        $this->client = $client;
    }

    public function getClient()
    {
        return $this->client;
    }

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

    protected static function getMapping()
    {
        return array(
            'id' => 'id',
            'name' => 'name'
        );
    }
}
