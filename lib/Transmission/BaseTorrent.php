<?php
namespace Transmission;

use Transmission\Model\File;
use Transmission\Model\Tracker;
use Transmission\Exception\NoSuchTorrentException;
use Transmission\Exception\InvalidResponseException;

/**
 * Base class for the Torrent class
 *
 * This class handles the actual communication with the Transmission server
 * and validates the received responses.
 *
 * @author Ramon Kleiss <ramon@cubilon.nl>
 */
class BaseTorrent
{
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
     * Set the client used to make API calls
     *
     * @param Transmission\Client $client
     */
    public function setClient(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Get the client used to make API calls
     *
     * @return Transmission\Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param boolean $deleteLocalData
     */
    protected function _delete($id, $deleteLocalData = false)
    {
        $arguments = array(
            'ids' => array($id),
            'delete-local-data' => $deleteLocalData
        );

        $response = $this->getClient()->call('torrent-remove', $arguments);

        self::validateResponse($response);
    }

    /**
     * @param Transmission\Client $client
     * @param array               $fields
     * @return array
     */
    protected static function _all(Client $client = null, array $fields)
    {
        $client = $client ?: new Client();

        $arguments = array(
            'fields' => $fields
        );

        $response = $client->call('torrent-get', $arguments);

        self::validateResponse($response, 'all');

        return $response->arguments->torrents;
    }

    /**
     * @param integer             $id
     * @param Transmission\Client $client
     * @param array               $fields
     * @return stdClass
     */
    protected static function _get($id, Client $client = null, array $fields)
    {
        $client = $client ?: new Client();

        $arguments = array(
            'fields' => $fields,
            'ids' => array($id)
        );

        $response = $client->call('torrent-get', $arguments);

        self::validateResponse($response, 'get');

        return $response->arguments->torrents[0];
    }

    /**
     * @param string              $torrent
     * @param Transmission\Client $client
     * @param boolean             $meta
     * @return stdClass
     */
    protected static function _add($torrent, Client $client = null, $meta = false)
    {
        $client = $client ?: new Client();

        $arguments[!$meta ? 'torrent' : 'metainfo'] = $torrent;

        $response     = $client->call('torrent-add', $arguments);
        $torrentField = 'torrent-added';

        self::validateResponse($response, 'add');

        return $response->arguments->$torrentField;
    }

    /**
     * @param stdClass $response
     * @param string   $method
     * @throws RuntimeException
     * @throws Transmission\Exception\InvalidResponseException
     */
    protected static function validateResponse(\stdClass $response, $method = null)
    {
        // Check if the result is set
        if (!isset($response->result)) {
            throw new InvalidResponseException(
                'Invalid response received from Transmission'
            );
        }

        // Check if the result is success
        if ($response->result !== 'success') {
            throw new \RuntimeException($response->result);
        }

        // Perform method dependent validation
        if ($method) {
            switch ($method) {
                case 'all':
                    self::validateAllResponse($response);
                    break;
                case 'get':
                    self::validateGetResponse($response);
                    break;
                case 'add':
                    self::validateAddResponse($response);
                    break;
            }
        }
    }

    /**
     * @param stdClass $response
     * @throws Transmission\Exception\NoSuchTorrentException
     * @throws Transmission\Exception\InvalidResponseException
     */
    protected static function validateGetResponse(\stdClass $response)
    {
        if (!isset($response->arguments) ||
            !isset($response->arguments->torrents)) {
            throw new InvalidResponseException(
                'Invalid response received from Transmission'
            );
        }

        if (count($response->arguments->torrents) == 0) {
            throw new NoSuchTorrentException('No such torrent found');
        }
    }

    /**
     * @param stdClass $response
     * @throws Transmission\Exception\InvalidResponseException
     */
    protected static function validateAllResponse(\stdClass $response)
    {
       if (!isset($response->arguments) ||
            !isset($response->arguments->torrents)) {
            throw new InvalidResponseException(
                'Invalid response received from Transmission'
            );
        }
    }

    /**
     * @param stdClass $response
     * @throws Transmission\Exception\InvalidResponseException
     */
    protected static function validateAddResponse(\stdClass $response)
    {
        $torrentField = 'torrent-added';

        if (!isset($response->arguments) ||
            !isset($response->arguments->$torrentField) ||
            empty($response->arguments->$torrentField)) {
            throw new InvalidResponseException(
                'Invalid response received from Transmission'
            );
        }
    }

    /**
     * @param stdClass $data
     * @return Transmission\Model\Tracker
     */
    protected static function parseTracker($data)
    {
        return ResponseTransformer::transform(
            $data,
            new Tracker(),
            Tracker::getMapping()
        );
    }

    /**
     * @param stdClass $data
     * @return Transmission\Model\File
     */
    protected static function parseFile($data)
    {
        return ResponseTransformer::transform(
            $data,
            new File(),
            File::getMapping()
        );
    }
}
