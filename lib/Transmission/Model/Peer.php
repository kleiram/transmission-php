<?php
namespace Transmission\Model;

/**
 * @author Ramon Kleiss <ramon@cubilon.nl>
 */
class Peer
{
    /**
     * The remote address of the peer
     *
     * @var string
     */
    protected $address;

    /**
     * The port the peer is listening on
     *
     * @var integer
     */
    protected $port;

    /**
     * The name of the client the peer uses
     *
     * @var string
     */
    protected $client;

    /**
     * Whether UTP is used to connect to the peer
     *
     * @var boolean
     */
    protected $utp;

    /**
     * Whether the connection is encrypted
     *
     * @var boolean
     */
    protected $encrypted;

    /**
     * Whether we are uploading to the peer
     *
     * @var boolean
     */
    protected $uploading;

    /**
     * Whether we are downloading from the peer
     *
     * @var boolean
     */
    protected $downloading;

    /**
     * Set the remote address of the peer
     *
     * @param string $address The remote address of the peer
     */
    public function setAddress($address)
    {
        $this->address = (string) $address;
    }

    /**
     * Get the remote address of the peer
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set the port the peer is listening on
     *
     * @param integer $port The port the peer is listening on
     */
    public function setPort($port)
    {
        $this->port = (integer) $port;
    }

    /**
     * Get the port the peer is listening on
     *
     * @return integer
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * Set the name of the client the peer uses
     *
     * @param string $client The name of the client
     */
    public function setClient($client)
    {
        $this->client = (string) $client;
    }

    /**
     * Get the name of the client the peer uses
     *
     * @return string
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Set whether we're connected to the peer using UTP
     *
     * @param boolean $utp Whether we're using TCP
     */
    public function setUtp($utp)
    {
        $this->utp = (boolean) $utp;
    }

    /**
     * Check if we're connected to the peer using UTP
     *
     * @return boolean
     */
    public function isUtp()
    {
        return $this->utp;
    }

    /**
     * Set if we use an encrypted connection
     *
     * @param boolean $encrypted Whether we're using an encrypted connection
     */
    public function setEncrypted($encrypted)
    {
        $this->encrypted = $encrypted;
    }

    /**
     * Check if we're using a encrypted connection to connect to the peer
     *
     * @return boolean
     */
    public function isEncrypted()
    {
        return $this->encrypted;
    }

    /**
     * Set if we're uploading to the peer
     *
     * @param boolean $uploading True if we're uploading to the peer
     */
    public function setUploading($uploading)
    {
        $this->uploading = (boolean) $uploading;
    }

    /**
     * Check if we're uploading to the peer
     *
     * @return boolean
     */
    public function isUploading()
    {
        return $this->uploading;
    }

    /**
     * Set if we're downloading from the peer
     *
     * @param boolean $downloading True if we're downloading from the peer
     */
    public function setDownloading($downloading)
    {
        $this->downloading = (boolean) $downloading;
    }

    /**
     * Check if we're downloading from the peer
     *
     * @return boolean
     */
    public function isDownloading()
    {
        return $this->downloading;
    }

    /**
     * @return array
     */
    public static function getMapping()
    {
        return array(
            'address' => 'address',
            'port' => 'port',
            'client' => 'client',
            'isUTP' => 'utp',
            'isEncrypted' => 'encrypted',
            'isUploading' => 'uploading',
            'isDownloading' => 'downloading'
        );
    }
}
