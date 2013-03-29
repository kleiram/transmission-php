<?php
namespace Transmission\Transformer;

use Transmission\Model\File;
use Transmission\Model\Peer;
use Transmission\Model\Tracker;
use Transmission\Model\Torrent;
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

        throw new InvalidResponseException('Invalid response received');
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
        $t = new Torrent();

        $t->setId(isset($torrent->id) ? $torrent->id : 0);
        $t->setName(isset($torrent->name) ? $torrent->name : '');
        $t->setSize(isset($torrent->totalSize) ? $torrent->totalSize : 0);
        $t->setDoneDate(isset($torrent->doneDate) ? $torrent->doneDate : 0);

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
        $p = new Peer();

        $p->setAddress(isset($peer->address) ? $peer->address : '');
        $p->setPort(isset($peer->port) ? $peer->port : 0);

        return $p;
    }

    /**
     * @param stdClass $file
     *
     * @return Transmission\Model\File
     */
    public function transformFile(\stdClass $file)
    {
        $f = new File();

        $f->setName(isset($file->name) ? $file->name : '');
        $f->setCompleted(isset($file->bytesCompleted) ? $file->bytesCompleted : 0);
        $f->setSize(isset($file->length) ? $file->length : 0);

        return $f;
    }

    /**
     * @param stdClass $tracker
     *
     * @return Transmission\Model\Tracker
     */
    public function transformTracker(\stdClass $tracker)
    {
        $t = new Tracker();

        $t->setId(isset($tracker->id) ? $tracker->id : 0);
        $t->setAnnounce(isset($tracker->announce) ? $tracker->announce : '');
        $t->setScrape(isset($tracker->scrape) ? $tracker->scrape : '');
        $t->setTier(isset($tracker->tier) ? $tracker->tier : 0);

        return $t;
    }
}
