<?php
namespace Transmission\Model;

/**
 * @author Ramon Kleiss <ramon@cubilon.nl>
 */
class Peer
{
    /**
     * @var string
     */
    protected $address;

    /**
     * @var integer
     */
    protected $port;

    /**
     * @var string
     */
    protected $client;

    /**
     * @var boolean
     */
    protected $utp;

    /**
     * @var boolean
     */
    protected $encrypted;

    /**
     * @var boolean
     */
    protected $uploading;

    /**
     * @var boolean
     */
    protected $downloading;

    /**
     * @param string $address
     */
    public function setAddress($address)
    {
        $this->address = (string) $address;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param integer $port
     */
    public function setPort($port)
    {
        $this->port = (integer) $port;
    }

    /**
     * @return integer
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * @param string $client
     */
    public function setClient($client)
    {
        $this->client = (string) $client;
    }

    /**
     * @return string
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param boolean $utp
     */
    public function setUtp($utp)
    {
        $this->utp = (boolean) $utp;
    }

    /**
     * @return boolean
     */
    public function isUtp()
    {
        return $this->utp;
    }

    /**
     * @param boolean $encrypted
     */
    public function setEncrypted($encrypted)
    {
        $this->encrypted = $encrypted;
    }

    /**
     * @return boolean
     */
    public function isEncrypted()
    {
        return $this->encrypted;
    }

    /**
     * @param boolean $uploading
     */
    public function setUploading($uploading)
    {
        $this->uploading = (boolean) $uploading;
    }

    /**
     * @return boolean
     */
    public function isUploading()
    {
        return $this->uploading;
    }

    /**
     * @param boolean $downloading
     */
    public function setDownloading($downloading)
    {
        $this->downloading = (boolean) $downloading;
    }

    /**
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
