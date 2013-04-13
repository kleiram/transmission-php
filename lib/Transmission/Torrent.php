<?php
namespace Transmission;

use Transmission\Model\File;
use Transmission\Model\Peer;
use Transmission\Model\Tracker;
use Transmission\Model\Torrent as BaseTorrent;
use Transmission\Exception\NoSuchTorrentException;
use Transmission\Exception\InvalidResponseException;

class Torrent extends BaseTorrent
{
    /**
     * Get all the torrents in the download queue
     *
     * @param Transmission\Client $client
     * @return array
     */
    public static function all(Client $client = null)
    {
        $client    = $client ?: new Client();
        $arguments = array(
            'fields' => array_keys(self::getMapping())
        );

        $response = $client->call('torrent-get', $arguments);

        self::validateResponse($response, 'all');

        $torrents = array();

        foreach ($response->arguments->torrents as $t) {
            $torrent = self::transformTorrent($t, $client);

            if (isset($t->files)) {
                foreach ($t->files as $file) {
                    $torrent->addFile(self::transformFile($file));
                }
            }

            if (isset($t->trackers)) {
                foreach ($t->trackers as $tracker) {
                    $torrent->addTracker(self::transformTracker($tracker));
                }
            }

            if (isset($t->peers)) {
                foreach ($t->peers as $peer) {
                    $torrent->addPeer(self::transformPeer($peer));
                }
            }

            $torrents[] = $torrent;
        }

        return $torrents;
    }

    /**
     * Get a torrent from the download queue by id
     *
     * @param integer             $id
     * @param Transmission\Client $client
     * @return Transmission\Torrent
     */
    public static function get($id, Client $client = null)
    {
        $client    = $client ?: new Client();
        $arguments = array(
            'fields' => array_keys(self::getMapping()),
            'ids' => array($id)
        );

        $response  = $client->call('torrent-get', $arguments);

        self::validateResponse($response, 'get');

        $torrent = self::transformTorrent(
            $response->arguments->torrents[0],
            $client
        );

        if (isset($response->arguments->torrents[0]->files)) {
            foreach ($response->arguments->torrents[0]->files as $file) {
                $torrent->addFile(self::transformFile($file));
            }
        }

        if (isset($response->arguments->torrents[0]->trackers)) {
            foreach ($response->arguments->torrents[0]->trackers as $tracker) {
                $torrent->addTracker(self::transformTracker($tracker));
            }
        }

        if (isset($response->arguments->torrents[0]->peers)) {
            foreach ($response->arguments->torrents[0]->peers as $peer) {
                $torrent->addPeer(self::transformPeer($peer));
            }
        }

        return $torrent;
    }

    /**
     * Add a torrent to the download queue
     *
     * @param string              $torrent
     * @param Transmission\Client $client
     * @param boolean             $meta
     * @return Transmission\Torrent
     */
    public static function add($torrent, Client $client = null, $meta = false)
    {
        $client    = $client ?: new Client();
        $arguments = array();
        $property  = 'torrent-added';

        $arguments[$meta ? 'metainfo' : 'torrent'] = (string) $torrent;

        $response  = $client->call('torrent-add', $arguments);

        self::validateResponse($response, 'add');

        return self::transformTorrent(
            $response->arguments->$property, $client
        );
    }

    /**
     * Remove a torrent from the download queue
     *
     * @param boolean $localData
     */
    public function delete($localData = false)
    {
        $arguments = array(
            'ids' => array($this->getId()),
            'delete-local-data' => $localData
        );

        $response = $this->getClient()->call('torrent-remove', $arguments);

        self::validateResponse($response, 'delete');
    }

    /**
     * @param stdClass            $torrentData
     * @param Transmission\Client $client
     * @return Transmission\Torrent
     */
    private static function transformTorrent(\stdClass $torrentData, Client $client)
    {
        return ResponseTransformer::transform(
            $torrentData,
            new Torrent($client),
            self::getMapping()
        );
    }

    /**
     * @param stdClass $fileData
     * @return Transmission\Model\File
     */
    private static function transformFile(\stdClass $fileData)
    {
        return ResponseTransformer::transform(
            $fileData,
            new File(),
            File::getMapping()
        );
    }

    /**
     * @param stdClass $trackerData
     * @return Transmission\Model\Tracker
     */
    private static function transformTracker(\stdClass $trackerData)
    {
        return ResponseTransformer::transform(
            $trackerData,
            new Tracker(),
            Tracker::getMapping()
        );
    }

    /**
     * @param stdClass $peerData
     * @return Transmission\Model\Peer
     */
    private static function transformPeer(\stdClass $peerData)
    {
        return ResponseTransformer::transform(
            $peerData,
            new Peer(),
            Peer::getMapping()
        );
    }

    /**
     * @param stdClass $response
     * @param string   $method
     */
    private static function validateResponse(\stdClass $response, $method = null)
    {
        if (!isset($response->result)) {
            throw new InvalidResponseException(
                'Invalid response received from Transmission'
            );
        }

        if ($response->result !== 'success') {
            throw new \RuntimeException(sprintf(
                'An error occured: "%s"', $response->result
            ));
        }

        switch ($method) {
            case 'get':
                return self::validateGetResponse($response);
            case 'all':
                return self::validateAllResponse($response);
            case 'add':
                return self::validateAddResponse($response);
        }
    }

    /**
     * @param stdClass $response
     */
    private static function validateGetResponse(\stdClass $response)
    {
        if (!isset($response->arguments) ||
            !isset($response->arguments->torrents)) {
            throw new InvalidResponseException(
                'Invalid response received from Transmission'
            );
        }

        if (!count($response->arguments->torrents)) {
            throw new NoSuchTorrentException('Torrent not found in queue');
        }
    }

    /**
     * @param stdClass $response
     */
    private static function validateAllResponse(\stdClass $response)
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
     */
    private static function validateAddResponse(\stdClass $response)
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
}
