<?php
namespace Transmission\Transformer;

use Transmission\Model\File;
use Transmission\Model\Peer;
use Transmission\Model\Tracker;
use Transmission\Model\Torrent;
use Transmission\Model\ModelInterface;
use Transmission\Exception\InvalidResponseException;

/**
 * @author Ramon Kleiss <ramon@cubilon.nl>
 */
class ModelTransformer implements TransformerInterface
{
    /**
     * {@inheritDoc}
     */
    public function transform(\stdClass $response)
    {
        if ($response->result !== 'success') {
            throw new InvalidResponseException(sprintf(
                'An error occured: "%s"', $response->result
            ));
        }

        $rootNode = null;

        if (isset($response->arguments)) {
            $rootNode = (object) $response->arguments;
        }

        if ($rootNode && isset($rootNode->torrents)) {
            return $this->transformTorrents($rootNode->torrents);
        }

        $torrentAdded = "torrent-added";

        if ($rootNode && isset($rootNode->$torrentAdded)) {
            return $this->transformTorrent($rootNode->$torrentAdded);
        }
    }

    /**
     * @param array $torrents
     *
     * @return array
     */
    public function transformTorrents(array $torrents)
    {
        $result = array();

        foreach ($torrents as $torrent) {
            $result[] = $this->transformTorrent($torrent);
        }

        return $result;
    }

    /**
     * @param stdClass $torrent
     *
     * @return Transmission\Model\Torrent
     */
    public function transformTorrent(\stdClass $torrent)
    {
        $t = $this->setProperties($torrent, new Torrent());

        if (isset($torrent->files)) {
            foreach ($torrent->files as $file) {
                $t->addFile($this->transformFile($file));
            }
        }

        if (isset($torrent->peers)) {
            foreach ($torrent->peers as $peer) {
                $t->addPeer($this->transformPeer($peer));
            }
        }

        if (isset($torrent->trackers)) {
            foreach ($torrent->trackers as $tracker) {
                $t->addTracker($this->transformTracker($tracker));
            }
        }

        return $t;
    }

    /**
     * @param stdClass $peer
     *
     * @return Transmission\Model\Peer
     */
    public function transformPeer(\stdClass $peer)
    {
        return $this->setProperties($peer, new Peer());
    }

    /**
     * @param stdClass $file
     *
     * @return Transmission\Model\File
     */
    public function transformFile(\stdClass $file)
    {
        return $this->setProperties($file, new File());
    }

    /**
     * @param stdClass $tracker
     *
     * @return Transmission\Model\Tracker
     */
    public function transformTracker(\stdClass $tracker)
    {
        return $this->setProperties($tracker, new Tracker());
    }

    /**
     * @param stdClass $fields
     * @param mixed    $object
     *
     * @return mixed
     */
    protected function setProperties(\stdClass $fields, ModelInterface $object)
    {
        foreach ($object->getFieldMap() as $property => $field) {
            if (isset($fields->$field)) {
                $setter = 'set'. ucfirst($property);

                if (method_exists($object, $setter)) {
                    $object->$setter($fields->$field);
                }
            }
        }

        return $object;
    }
}
